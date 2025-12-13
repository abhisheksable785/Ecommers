<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewImage;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    // List reviews for a product with pagination
    public function index($productId)
    {
        $reviews = Review::with(['user', 'images'])
            ->where('product_id', $productId)
            ->where('is_approved', true) // only approved
            ->orderByDesc('created_at')
            ->paginate(10);

        // add average and totals
        $avg = Review::where('product_id', $productId)->avg('rating');
        $count = Review::where('product_id', $productId)->count();

        return response()->json([
            'success' => true,
            'data' => [
                'avg_rating' => round((float) $avg, 2),
                'total_reviews' => $count,
                'reviews' => $reviews,
            ],
        ]);
    }

    // Check if current user can review product (has purchased and hasn't reviewed)
    public function canReview(Request $request, $productId)
    {
        $userId = auth()->id();

        // already reviewed?
        $already = Review::where('user_id', $userId)->where('product_id', $productId)->exists();

        // purchased?
        $purchased = $this->hasPurchased($userId, $productId);

        return response()->json([
            'success' => true,
            'can_review' => !$already && $purchased,
            'already_reviewed' => $already,
            'purchased' => $purchased,
        ]);
    }

    // Store or update review
    public function store(Request $request, $productId)
    {
        $userId = auth()->id();
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // check purchase
        $purchased = $this->hasPurchased($userId, $productId);
        if (! $purchased) {
            return response()->json(['success' => false, 'message' => 'You can only review products you have purchased.'], 403);
        }

        // allow update if exists else create
        $review = Review::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $productId],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'is_verified_purchase' => $purchased,
                // if you want admin approval set is_approved false by default
                'is_approved' => true,
            ]
        );

        // images handling
        if ($request->hasFile('images')) {
            // optionally delete old images
            foreach ($request->file('images') as $file) {
                $path = $file->store('reviews', 'public');
                ReviewImage::create([
                    'review_id' => $review->id,
                    'path' => $path,
                ]);
            }
        }
        if ($user->onesignal_player_id) {
                \App\Helpers\OneSignalHelper::sendToUser(
                    $user->onesignal_player_id,
                    "Your  Fedback Send!",
                    "Thank You for Your FeedBack!"
                );
            }

        return response()->json(['success' => true, 'message' => 'Review submitted', 'review' => $review]);
    }

    // optional: delete review
    public function destroy(Request $request, $productId)
    {
        $userId = auth()->id();
        $review = Review::where('user_id', $userId)->where('product_id', $productId)->first();
        if (!$review) {
            return response()->json(['success'=>false, 'message'=>'Review not found'], 404);
        }

        // delete images files
        foreach ($review->images as $img) {
            Storage::disk('public')->delete($img->path);
            $img->delete();
        }

        $review->delete();

        return response()->json(['success'=>true, 'message'=>'Review deleted']);
    }

    // helper: check if user purchased the product
    protected function hasPurchased($userId, $productId): bool
    {
        $orders = Order::where('user_id', $userId)
            ->where(function($q){
                $q->where('payment_status','success')->orWhere('status','completed')->orWhere('payment_status','captured');
            })
            ->pluck('id');
            
        if ($orders->isEmpty()) return false;

        $count =OrderItems::whereIn('order_id', $orders)->where('product_id', $productId)->count();

        return $count > 0;
    }
}
