<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist
     */
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->paginate(12);

        return view('ecatalog.wishlist', compact('wishlistItems'));
    }

    /**
     * Add a product to wishlist
     */
    public function add($id)
    {
        $product = Product::findOrFail($id);
        
        // Check if already in wishlist
        $existingWishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if ($existingWishlist) {
            return redirect()->back()->with('error', 'Produk sudah ada di wishlist Anda.');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $id,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke wishlist.');
    }

    /**
     * Remove a product from wishlist
     */
    public function remove($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->firstOrFail();

        $wishlist->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari wishlist.');
    }
}