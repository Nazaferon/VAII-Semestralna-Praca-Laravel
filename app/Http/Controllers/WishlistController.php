<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $wishlists = Wishlist::latest()->where("user_id", "=", $user->id)->get();
        return view("wishlists.index", [
            "wishlists" => $wishlists
        ]);
    }

    public function store(Item $item)
    {
        $status = Wishlist::where("user_id", auth()->user()->id)
            ->where("item_id", $item->id)
            ->first();
        if ($status ?? false)
            return back()->with("message", "Táto položka už je vo vašom zozname prianí!");
        else {
            $wishlist = new Wishlist;
            $wishlist->user_id = auth()->user()->id;
            $wishlist->item_id = $item->id;
            $wishlist->save();
            return back()->with("message", "Pridané do vášho zoznamu prianí!");
        }
    }

    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();
        return back()->with("message", "Položka bola úspešne odstránená z vášho zoznamu prianí!");
    }
}
