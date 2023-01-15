@extends('layouts.header')

@section('content')
    <a id="back-to-top" href="#" class="btn btn-light btn-lg back-to-top" role="button"><i class="fa fa-chevron-up"></i></a>
    @include('includes.top_side_nav_bar')
    <div class="container-fluid bottom-container">
        @include('includes.flash_message')
        <div class="row pt-1">
            <div class="col-7">
                <img src="{{asset("storage/images/items/" . $item->image_path)}}" alt="Image" class="d-block m-auto"
                     style="width:45%"/>
            </div>
            <div class="col-5">
                <h3><strong>{{$item->brand . " " . $item->model}}</strong></h3>
                @php
                    $item_date = $item->created_at;
                    $item_date->modify("+1 month");
                @endphp
                @if ($item_date >= date('Y-m-d h:i:s'))
                    <h5><span class="badge bg-primary">Novinka</span></h5>
                @endif
                <p class="text-muted" style="font-size: 18px">{{$item->category}}</p>
                <div class="card">
                    <div class="card-body">
                        <h3><strong>€{{$item->price}}</strong></h3>
                        <p class="text-success pt-1" style="font-size: 18px"><i class="fa fa-check" aria-hidden="true"></i><u>Doprava zdarma</u></p>
                        <h5 class="text-success"><strong>Na sklade pre e-shop {{$item->amount}} ks</strong></h5>
                        <div class="row pb-3 pt-3">
                            <div class="col">
                                <form action="/shopping-basket/store/{{$item->id}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success rounded-pill" style="text-align: center;">
                                        <h5><i class="fa fa-shopping-cart pt-2" aria-hidden="true"></i> Vlož do košíka</h5>
                                    </button>
                                </form>
                            </div>
                            <div class="col">
                                <form action="/wishlists/store/{{$item->id}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-danger rounded-pill" style="text-align: center;">
                                        <h5><i class="fa fa-heart pt-2" aria-hidden="true"></i> Pridať do zoznamu prianí</h5>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <header class="card-header">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" type="button" role="tab"
                                aria-controls="description-tab-pane" aria-selected="true" data-bs-toggle="tab"
                                data-bs-target="#description-tab-pane">Popis
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ratings-tab" type="button" role="tab"
                                aria-controls="ratings-tab-pane" aria-selected="true" data-bs-toggle="tab"
                                data-bs-target="#ratings-tab-pane">Hodnotenie
                        </button>
                    </li>
                </ul>
            </header>
        </div>
        <div class="tab-content mt-1">
            <div class="tab-pane fade show active" id="description-tab-pane" role="tabpanel"
                 aria-labelledby="description-tab" tabindex="0">{{$item->description}}</div>
            <div class="tab-pane fade" id="ratings-tab-pane" role="tabpanel" aria-labelledby="ratings-tab" tabindex="0">
                ...
            </div>
        </div>
    </div>
@endsection
