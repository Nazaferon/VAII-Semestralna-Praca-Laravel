<?php

namespace App\Http\Controllers;

use App\Models\Item;
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
        else
            $items = $items->sortBy("price");
        return $items;
    }

    public function refreshItemsTable(Request $request)
    {
        $items = $this->getSievedItems($request);
        $code =
            '<div id="home-table">
                <div class="row pt-3 px-1">';
        foreach ($items as $item) {
            $code .=
                '    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 pb-3 px-2">
                        <a class="card text-decoration-none h-100" href="/items/show' . $item->id . '"
                           style="overflow: hidden">
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <img src="' . asset("storage/images/items/" . $item->image_path) . '" class="card-img-top pb-3" alt="Image"/>';
            $date = new DateTime();
            $date->format('Y-m-d h:i:s');
            $date->modify("-1 month");
            if ($item->created_at >= $date)
                $code .=
                                        '<h5>
                                            <span class="badge bg-primary" style="position: absolute; top: 244px;">Novinka</span>
                                        </h5>';
            $code .=
                '                   </li>
                                        <li class="list-group-item">
                                            <h6 class="card-title">' . $item->brand . " " . $item->model . '</h6>
                                            <p class="mb-2">' . $item->category . '</p>
                                            <h6><strong>€' . $item->price . '</strong></h6>
                                            <p class="mb-0">Na sklade: <span class="fw-bold">' . $item->amount . '</span>
                                            </p>
                                            <div class="ms-auto text-warning">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
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
        return view("items.show", [
           "item" => $item
        ]);
    }
}
