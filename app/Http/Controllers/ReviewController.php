<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewImage;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:tbl_product,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userId = auth()->id();
        $productId = $request->product_id;

        // Check if user purchased the product
        // if (!$this->hasPurchased($userId, $productId)) {
        //     return redirect()->back()->with('error', 'You can only review products you have purchased.');
        // }

        // Create or update review
        $review = Review::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $productId],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'is_verified_purchase' => true,
                'is_approved' => true, // Auto-approve for now, or set to false if admin approval is needed
            ]
        );

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('reviews', 'public');
                ReviewImage::create([
                    'review_id' => $review->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }

    protected function hasPurchased($userId, $productId)
    {
        $orders = Order::where('user_id', $userId)
            ->where(function($q){
                $q->where('payment_status','success')
                  ->orWhere('status','completed')
                  ->orWhere('payment_status','captured');
            })
            ->pluck('id');

        if ($orders->isEmpty()) return false;

        return OrderItems::whereIn('order_id', $orders)->where('product_id', $productId)->exists();
    }
}
