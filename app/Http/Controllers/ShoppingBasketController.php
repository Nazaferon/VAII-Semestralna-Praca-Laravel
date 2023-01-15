<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;

class ShoppingBasketController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = Order::latest()->where("user_id", "=", $user->id)->get();
        return view("shopping_basket.index", [
            "user" => $user,
            "orders" => $orders
        ]);
    }

    public function storeAll(Request $request)
    {
        $item_id_all = $request->get("item_id_all");
        foreach ($item_id_all as $item_id) {
            $status = Order::where("user_id", auth()->user()->id)
                ->where("item_id", $item_id)
                ->first();
            if ($status == null) {
                $order = new Order;
                $order->user_id = auth()->user()->id;
                $order->item_id = $item_id;
                $order->save();
            }
        }
        return back()->with("message", "Pridané do vášho nákupného košíka!");
    }

    public function store(Item $item)
    {
        $status = Order::where("user_id", auth()->user()->id)
            ->where("item_id", $item->id)
            ->first();
        if ($status ?? false)
            return back()->with("message", "Tento tovar je už vo vašom nákupnom košíku!");
        else {
            $order = new Order;
            $order->user_id = auth()->user()->id;
            $order->item_id = $item->id;
            $order->save();
            return back()->with("message", "Pridané do vášho nákupného košíka!");
        }
    }

    public function updateAmount(Request $request)
    {
        $orderAmount = $request->get("orderAmount");
        $orderId = $request->get("orderId");
        $order = Order::where("id", "=", $orderId)->first();
        $order->amount = $orderAmount;
        $order->save();

        $orders = Order::latest()->get();
        $priceSum = 0;
        $code = '
                <div id="shopping-basket-table">';
        foreach ($orders as $order) {
            $priceSum += $order->item->price * $order->amount;
            $code .= '
                    <div class="row align-items-center">
                        <div class="col-2">
                            <a class="text-reset text-decoration-none" href="/items/show/' . $order->item->id . '">
                                <img src="' . asset("storage/images/items/" . $order->item->image_path) . '" class="py-3 object-fit-contain w-100" alt="Image"/>
                            </a>
                        </div>
                        <div class="col">
                            <a class="text-reset text-decoration-none" href="/items/show/' . $order->item->id . '">
                                <h5>' . $order->item->brand . " " . $order->item->model . '</h5>
                                <p class="mb-2">' . $order->item->category . '</p>
                                <p class="mb-0">Na sklade: <span class="fw-bold">' . $order->item->amount . '</span>
                            </a>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex flex-row justify-content-center">
                                <h5 class="px-1">' . $order->amount . '</h5>
                            </div>
                            <div class="d-flex flex-row justify-content-center">
                                <div class="col px-2">
                                    <button type="button" onclick="increaseOrderAmount(' . $order->id . ',' . $order->amount . ')" class="btn btn-light border rounded-pill" style="text-align: center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Pridať jeden">
                                        <i class="fa fa-plus pb-0" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div class="col px-1">
                                    <button type="button" onclick="reduceOrderAmount(' . $order->id . ',' . $order->amount . ')" class="btn btn-light border rounded-pill" style="text-align: center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Odstrániť jeden">
                                        <i class="fa fa-minus pb-0" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex flex-row justify-content-end">
                                <h5>€' . $order->item->price * $order->amount . '</h5>
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                                <form action="/shopping-basket/destroy/' . $order->id . '" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <button type="submit" class="btn btn-danger rounded-pill" style="text-align: center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Odstrániť z nákupného košíka">
                                        <i class="fa fa-times pb-0" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <span class="border-bottom"></span>
                    </div>';
        }
        $code .= '
                    <div class="row align-items-center border-bottom mt-1 py-3">
                        <div class="col">
                            <h5>Cena spolu:</h5>
                        </div>
                        <div class="col-auto col-sm-auto">
                            <h5>€' . $priceSum . '</h5>
                        </div>
                    </div>
                </div>';
        return json_encode($code);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with("message", "Položka bola úspešne odstránená z vášho nákupného košíka!");
    }
}
