<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AddToBag;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddToCardController extends Controller
{
    /**
     * Add product to bag
     */
    public function addToBag(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:tbl_product,id',
            'quantity' => 'required|integer|min:1|max:10',
            'price' => 'required|numeric|min:0',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to add items to your bag',
                ], 401);
            }

            // Check product stock
            $product = Product::find($request->product_id);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                ], 404);
            }

            if ($product->in_stock != 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is out of stock',
                ], 400);
            }

            // Check if item already exists in bag
            $bagItem = AddToBag::where([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'size' => $request->size,
                'color' => $request->color,
            ])->first();

            if ($bagItem) {
                // Update quantity
                $newQuantity = $bagItem->quantity + $request->quantity;
                
                // Check max quantity
                if ($newQuantity > 10) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maximum quantity (10) reached for this item',
                    ], 400);
                }

                // Check stock quantity
                if ($product->stock_quantity && $newQuantity > $product->stock_quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "Only {$product->stock_quantity} items available in stock",
                    ], 400);
                }

                $bagItem->quantity = $newQuantity;
                $bagItem->save();
            } else {
                // Create new bag item
                if ($product->stock_quantity && $request->quantity > $product->stock_quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "Only {$product->stock_quantity} items available in stock",
                    ], 400);
                }

                $bagItem = AddToBag::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'price_at_purchase' => $request->price,
                    'size' => $request->size,
                    'color' => $request->color,
                ]);
            }

            // Get updated cart count
            $cartCount = AddToBag::where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'message' => 'Product added to bag successfully',
                'data' => [
                    'bag_item' => $bagItem,
                    'cart_count' => $cartCount,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to bag',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get bag items
     */
    public function getBag()
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to view your bag',
                ], 401);
            }

            $bagItems = AddToBag::with('product')
                ->where('user_id', Auth::id())
                ->get();

            $subtotal = $bagItems->sum(function($item) {
                return $item->price_at_purchase * $item->quantity;
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'items' => $bagItems,
                    'subtotal' => $subtotal,
                    'count' => $bagItems->count(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch bag items',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update bag item quantity
     */
    public function updateQuantity(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login',
                ], 401);
            }

            $bagItem = AddToBag::where('id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$bagItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in bag',
                ], 404);
            }

            // Check stock
            $product = Product::find($bagItem->product_id);
            if ($product && $product->stock_quantity && $request->quantity > $product->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$product->stock_quantity} items available in stock",
                ], 400);
            }

            $bagItem->quantity = $request->quantity;
            $bagItem->save();

            // Get updated subtotal
            $subtotal = AddToBag::where('user_id', Auth::id())
                ->sum(DB::raw('price_at_purchase * quantity'));

            return response()->json([
                'success' => true,
                'message' => 'Quantity updated successfully',
                'data' => [
                    'bag_item' => $bagItem,
                    'subtotal' => $subtotal,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update quantity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from bag
     */
    public function removeFromBag($id)
    {
        try {
            $bagItem = AddToBag::where('id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$bagItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in bag',
                ], 404);
            }

            $bagItem->delete();

            $cartCount = AddToBag::where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from bag',
                'data' => [
                    'cart_count' => $cartCount,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear entire bag
     */
    public function clearBag()
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login',
                ], 401);
            }

            AddToBag::where('user_id', Auth::id())->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bag cleared successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear bag',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cart count
     */
    public function getCartCount()
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => true,
                    'data' => ['count' => 0]
                ], 200);
            }

            $count = AddToBag::where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'data' => ['count' => $count]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get cart count',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}