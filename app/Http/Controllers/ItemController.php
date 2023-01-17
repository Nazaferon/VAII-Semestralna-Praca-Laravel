<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Rating;
use DateTime;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->getSievedItems($request);
        if ($request->session()->has("category"))
            $category = $request->session()->get("category");
        else
            $category = "Všetky gitary";
        if ($request->session()->has("brand"))
            $brand = $request->session()->get("brand");
        else
            $brand = "";
        foreach ($items as $item) {
            $ratings_count = $item->ratings()->count();
            $rating_value = 0;
            foreach ($item->ratings()->get() as $rating)
                $rating_value += $rating->value;
        }
        return view("items.index", [
            "items" => $items,
            "category" => $category,
            "brand" => $brand
        ]);
    }

    public function getSievedItems(Request $request)
    {
        if ($request->query->has("category")) {
            if ($request->query("category") == "acoustic_guitars")
                $request->session()->put("category", "Akustické gitary");
            else if ($request->query("category") == "electric_acoustic_guitars")
                $request->session()->put("category", "Elektroakustické gitary");
            else if ($request->query("category") == "bass_guitars")
                $request->session()->put("category", "Basgitary");
            else if ($request->query("category") == "electric_guitars")
                $request->session()->put("category", "Elektrické gitary");
            else if ($request->query("category") == "all")
                $request->session()->forget("category");
        }
        if ($request->query->has("brand")) {
            if ($request->query("brand") == "gibson")
                $request->session()->put("brand", "Gibson");
            else if ($request->query("brand") == "fender")
                $request->session()->put("brand", "Fender");
            else if ($request->query("brand") == "prs")
                $request->session()->put("brand", "PRS");
            else if ($request->query("brand") == "ibanez")
                $request->session()->put("brand", "Ibanez");
            else if ($request->query("brand") == "esp")
                $request->session()->put("brand", "ESP");
            else if ($request->query("brand") == "jackson")
                $request->session()->put("brand", "Jackson");
            else if ($request->query("brand") == "all")
                $request->session()->forget("brand");
        }
        $items = Item::filter([
            "category" => $request->session()->get("category"),
            "brand" => $request->session()->get("brand"),
            "search" => $request->get("search"),
            "min_price" => $request->get("min_price"),
            "max_price" => $request->get("max_price"),
            "available" => $request->get("available"),
            "newer" => $request->get("newer")
        ])->get();
        if ($request->get("sorter") == "less-expensive")
            $items = $items->sortBy("price");
        else  if ($request->get("sorter") == "most-expensive")
            $items = $items->sortByDesc("price");
        else {
            $items = $items->sortByDesc(function($item) {
                $rating_value = 0;
                $ratings = $item->ratings()->get();
                foreach ($ratings as $rating)
                    $rating_value += $rating->value;
                if ($ratings->count() > 1)
                    $rating_value /= $ratings->count();
                return $rating_value;
            });
        }
        return $items;
    }

    public function refreshItemsTable(Request $request)
    {
        $items = $this->getSievedItems($request);
        $code =
            '<div class="row pt-3 px-1">';
        foreach ($items as $item) {
            $code .=
                '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 pb-3 px-2">
                    <a class="card text-decoration-none h-100" href="/items/show/' . $item->id . '" style="overflow: hidden">
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <img src="' . asset("storage/images/items/" . $item->image_path) . '" class="card-img-top pb-3" alt="Image"/>';
            $date = new DateTime();
            $date->format('Y-m-d h:i:s');
            $date->modify("-1 month");
            if ($item->created_at >= $date)
                $code .=
                    '               <h5>
                                        <span class="badge bg-primary" style="position: absolute; top: 244px;">Novinka</span>
                                    </h5>';
            $code .=
                '               </li>
                                <li class="list-group-item">
                                    <h6 class="card-title">' . $item->brand . " " . $item->model . '</h6>
                                    <p class="mb-2">' . $item->category . '</p>
                                    <h6><strong>€' . $item->price . '</strong></h6>
                                    <p class="mb-0">Na sklade: <span class="fw-bold">' . $item->amount . '</span>
                                    </p>';
            $ratings_count = $item->ratings()->count();
            if ($ratings_count > 0) {
                $rating_value = 0;
                foreach ($item->ratings()->get() as $rating)
                    $rating_value += $rating->value;
                $rating_value /= $item->ratings()->count();
                $rating_value_fraction = $rating_value - floor($rating_value);
                $code .= '
                                    <div class="text-warning" style="display: inline-block;">';
                for ($i = 1; $i <= $rating_value; $i++)
                    $code .= '
                                        <i class="fa fa-star"></i>';
                if ($rating_value_fraction >= 0.5)
                    $code .= '
                                        <i class="fa fa-star-half-o"></i>';
                $code .= '
                                    </div>
                                    <div class="text-secondary" style="display: inline-block;">';
                for ($i = $rating_value + 1; $i <= 5; $i++)
                    $code .= '
                                        <i class="fa fa-star"></i>';
                $code .= '
                                    </div>';
            }
            $code .= '
                                </li>
                            </ul>
                        </div>
                    </a>
                </div>';
        }
        return json_encode($code);
    }

    public function show(Item $item)
    {
        $user = auth()->user();
        if ($user) {
            $user_rating = Rating::where("item_id", "=", $item->id)->where("user_id", "=", $user->id)->first();
            $other_ratings = Rating::where("item_id", "=", $item->id)->where("user_id", "!=", $user->id)->get();
        }
        else {
            $user_rating = null;
            $other_ratings = Rating::where("item_id", "=", $item->id)->get();
        }
        return view("items.show", [
            "item" => $item,
            "other_ratings" => $other_ratings,
            "user_rating" => $user_rating
        ]);
    }
}
