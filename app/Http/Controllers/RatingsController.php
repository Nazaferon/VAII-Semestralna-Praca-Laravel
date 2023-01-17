<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $ratings = Rating::latest()->where("user_id", "=", $user->id)->get();
        return view("ratings.index", [
            "ratings" => $ratings
        ]);
    }

    public function store(Item $item, Request $request)
    {
        $rating = new Rating();
        $rating->user_id = auth()->user()->id;
        $rating->item_id = $item->id;
        $rating->value = $request->get("rating_value");
        $rating->review = $request->get("review");
        $rating->save();
        return back()->with("message", "Vaša recenzia bola úspešne pridaná!");
    }

    public function update(Item $item, Request $request)
    {
        $user = auth()->user();
        $user_rating = Rating::where("user_id", "=", $user->id)->where("item_id", "=", $item->id)->first();
        $user_rating->value = $request->get("rating_value");
        $user_rating->review = $request->get("review");
        $user_rating->save();
        return back()->with("message", "Vaša recenzia bola úspešne zmenená!");
    }

    public function destroy(Item $item)
    {
        $user = auth()->user();
        $user_rating = Rating::where("user_id", "=", $user->id)->where("item_id", "=", $item->id)->first();
        $user_rating->delete();
        return back()->with("message", "Vaša recenzia bola odstránená!");
    }

    /**public function refreshItemReviews(Request $request)
    {
        $code = '';
        $item_id = $request->get("item_id");
        $ratings = Rating::latest()->where("item_id", "=", $item_id)->get();
        foreach ($ratings as $rating) {
            $code .= '
                    <div class="row">
                        <div class="col-auto">
                            <h5>' . $rating->user->firstname . " " . $rating->user->lastname . '</h5>
                        </div>
                        <div class="col-auto">
                            <div class="row">';
            for ($i = 1; $i <= $rating->value; $i++)
                $code .= '
                                <div class="col">
                                    <div class="ms-auto text-warning">
                                        <i class="fa fa-star"></i >
                                    </div>
                                </div>';
            for ($i = $rating->value + 1; $i <= 5; $i++)
                $code .= '
                                    <div class="col">
                                        <div class="ms-auto text-secondary">
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>';
            $code .= '
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p class="mb-3">' . $rating->review . ' </p>
                            <span class="border-bottom mb-3"></span>
                        </div>';
        }
        return json_encode($code);
    }**/
}
