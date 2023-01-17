@extends('layouts.header')

@section('content')
    <a id="back-to-top" href="#" class="btn btn-light btn-lg back-to-top" role="button"><i class="fa fa-chevron-up"></i></a>
    @include('includes.top_side_nav_bar')
    <div class="container-fluid bottom-container">
        @include('includes.left_side_nav_bar')
        <div class="container-fluid guitars">
            @include('includes.flash_message')
            <h3>{{$category . " " . $brand}}</h3>
            <div class="card-group">
                <div class="card">
                    <header class="card-header">
                        <h6 class="title">Cena:</h6>
                        <div class="card-body pb-0 pt-0">
                            <div class="row">
                                <div class="col">
                                    <label>Od</label>
                                    <input type="number" class="form-control" id="min_price" placeholder="0 EUR" onchange="sieveItems({{null}})">
                                </div>
                                <div class="col">
                                    <label>Do</label>
                                    <input type="number" class="form-control" id="max_price" placeholder="10,000 EUR" onchange="sieveItems({{null}})">
                                </div>
                            </div>
                        </div>
                    </header>
                </div>
                <div class="card">
                    <header class="card-header h-100">
                        <div class="card-body pb-0 pt-0">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="available" onchange="sieveItems()">
                                <label class="custom-control-label" for="available">Skladom</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="newer" onchange="sieveItems()">
                                <label class="custom-control-label" for="newer">Novinka</label>
                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <div class="card">
                <header class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active sorting-tabs" id="most-popular" type="button" role="tab" data-bs-toggle="tab" onclick="sieveItems()">Najpopulárnejšie</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link sorting-tabs" id="less-expensive" type="button" role="tab" data-bs-toggle="tab" onclick="sieveItems()">Najlacnejšie</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link sorting-tabs" id="most-expensive" type="button" role="tab" data-bs-toggle="tab" onclick="sieveItems()">Najdrahšie</button>
                        </li>
                    </ul>
                </header>
            </div>
            <div id="home-table">
                <div class="row pt-3 px-1">
                    @foreach ($items as $item)
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 pb-3 px-2">
                            <a class="card text-decoration-none h-100" href="/items/show/{{$item->id}}"
                               style="overflow: hidden">
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <img src="{{asset("storage/images/items/" . $item->image_path)}}"
                                                 class="card-img-top pb-3" alt="Image"/>
                                            <h5>
                                                @php
                                                    $date = new DateTime();
                                                    $date->format('Y-m-d h:i:s');
                                                    $date->modify("-1 month");
                                                @endphp
                                                @if ($item->created_at >= $date)
                                                    <span class="badge bg-primary"
                                                          style="position: absolute; top: 244px;">Novinka</span>
                                                @endif
                                            </h5>
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="card-title">{{$item->brand . " " . $item->model}}</h6>
                                            <p class="mb-2">{{$item->category}}</p>
                                            <h6><strong>€{{$item->price}}</strong></h6>
                                            <p class="mb-0">Na sklade: <span class="fw-bold">{{$item->amount}}</span>
                                            </p>
                                            @php
                                                $ratings_count = $item->ratings()->count();
                                            if ($ratings_count > 0) {
                                                $rating_value = 0;
                                                foreach ($item->ratings()->get() as $rating)
                                                    $rating_value += $rating->value;
                                                $rating_value /= $item->ratings()->count();
                                                $rating_value_fraction = $rating_value - floor($rating_value);
                                                @endphp
                                                <div class="text-warning" style="display: inline-block;">
                                                @for ($i = 1; $i <= $rating_value; $i++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                                @if ($rating_value_fraction >= 0.5)
                                                    <i class="fa fa-star-half-o"></i>
                                                @endif
                                                </div>
                                                <div class="text-secondary" style="display: inline-block;">
                                                @for ($i = $rating_value + 1; $i <= 5; $i++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                            </div>
                                            @php } @endphp
                                        </li>
                                    </ul>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
