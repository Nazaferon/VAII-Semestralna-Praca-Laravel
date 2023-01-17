@extends('layouts.header')

@section('content')
    <a id="back-to-top" href="#" class="btn btn-light btn-lg back-to-top" role="button"><i class="fa fa-chevron-up"></i></a>
    @include('includes.top_side_nav_bar')
    <div class="container-fluid bottom-container">
        @include('includes.flash_message')
        <div class="row pt-1">
            <div class="col-0 col-sm-0 col-lg-1 col-xl-1"></div>
            <div class="col-10 col-sm-6 col-lg-5 col-xl-4 text-center inline">
                <img src="{{asset("storage/images/items/" . $item->image_path)}}" class=object-fit-contain"" style="width:100%" alt="Image"/>
            </div>
            <div class="col-0 col-sm-0 col-lg-1 col-xl-2"></div>
            <div class="col">
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
                        <button class="nav-link active" id="description-tab" type="button" role="tab" aria-controls="description-tab-pane"
                                aria-selected="true" data-bs-toggle="tab" data-bs-target="#description-tab-pane">Popis
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ratings-tab" type="button" role="tab" aria-controls="ratings-tab-pane"
                                aria-selected="true" data-bs-toggle="tab" data-bs-target="#ratings-tab-pane">Hodnotenie
                        </button>
                    </li>
                </ul>
            </header>
        </div>
        <div class="tab-content mt-3">
            <div class="tab-pane mb-3 fade show active" id="description-tab-pane" role="tabpanel" aria-labelledby="description-tab" tabindex="0">
                {{$item->description}}
            </div>
            <div class="tab-pane fade" id="ratings-tab-pane" role="tabpanel" aria-labelledby="ratings-tab" tabindex="1">
                @auth
                    @if ($user_rating == null)
                        <div class="row">
                            <div class="row">
                                <div class="col-auto">
                                    <h5>{{auth()->user()->firstname . " " . auth()->user()->lastname}}</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="row">
                                        <div class="col" onclick="setRatingValue(1)">
                                            <div class="text-warning" id="star_1">
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="col" onclick="setRatingValue(2)">
                                            <div class="text-secondary" id="star_2">
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="col" onclick="setRatingValue(3)">
                                            <div class="text-secondary" id="star_3">
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="col" onclick="setRatingValue(4)">
                                            <div class="text-secondary" id="star_4">
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="col" onclick="setRatingValue(5)">
                                            <div class="text-secondary" id="star_5">
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <form method="post" action="/ratings/store/{{$item->id}}">
                                    @csrf
                                        <label for="review">Napíšte svoju recenziu</label>
                                        <textarea class="form-control mb-3" name="review" id="review" rows="2"></textarea>
                                        <input type="hidden" id="rating_value" name="rating_value" value="1">
                                        <button type="submit" class="btn btn-primary mb-3" style="text-align: center">
                                            Uložiť recenziu
                                        </button>
                                </form>
                            </div>
                            <span class="border-bottom mb-3"></span>
                        </div>
                    @else
                        <div id="update_review_form" style="display : none">
                            <div class="row">
                                <div class="row">
                                    <div class="col-auto">
                                        <h5>{{auth()->user()->firstname . " " . auth()->user()->lastname}}</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="row">
                                            @for ($i = 1; $i <= $user_rating->value; $i++)
                                                <div class="col" onclick="setRatingValue({{$i}})">
                                                    <div class="text-warning" id="star_{{$i}}">
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                            @endfor
                                            @for ($i = $user_rating->value + 1; $i <= 5; $i++)
                                                <div class="col" onclick="setRatingValue({{$i}})">
                                                    <div class="text-secondary" id="star_{{$i}}">
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <form method="post" action="/ratings/update/{{$item->id}}">
                                        @csrf
                                        <label for="review">Napíšte svoju recenziu</label>
                                        <textarea class="form-control mb-3" name="review" id="review" rows="2">{{$user_rating->review}}</textarea>
                                        <input type="hidden" id="rating_value" name="rating_value" value="{{$user_rating->value}}">
                                        <button type="submit" class="btn btn-primary mb-3" style="text-align: center">
                                            Uložiť recenziu
                                        </button>
                                    </form>
                                </div>
                                <span class="border-bottom mb-3"></span>
                            </div>
                        </div>
                        <div id="read_review">
                            <div class="row">
                                <div class="col-auto">
                                    <h5>{{$user_rating->user->firstname . " " . $user_rating->user->lastname}}</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="row">
                                        @for ($i = 1; $i <= $user_rating->value; $i++)
                                            <div class="col">
                                                <div class="ms-auto text-warning">
                                                    <i class="fa fa-star"></i >
                                                </div>
                                            </div>
                                        @endfor
                                        @for ($i = $user_rating->value + 1; $i <= 5; $i++)
                                            <div class="col">
                                                <div class="ms-auto text-secondary">
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="mb-3">{{$user_rating->review}}</p>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <button type="button" onclick="showUpdateReviewForm()" class="btn btn-primary mb-3" style="text-align: center">
                                        Upraviť recenziu
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <form method="post" action="/ratings/destroy/{{$item->id}}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger mb-3" style="text-align: center">
                                            Odstrániť recenziu
                                        </button>
                                    </form>
                                </div>
                                <span class="border-bottom mb-3"></span>
                            </div>
                        </div>
                    @endif
                @endauth
                <div id="reviews">
                    @if ($other_ratings->count() == 0)
                        <p class="mb-3">Pod touto položkou nie sú žiadne recenzie od iných používateľov.</p>
                    @else
                        @foreach($other_ratings as $rating)
                            <div class="row">
                                <div class="col-auto">
                                    <h5>{{$rating->user->firstname . " " . $rating->user->lastname}}</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="row">
                                        @for ($i = 1; $i <= $rating->value; $i++)
                                            <div class="col">
                                                <div class="ms-auto text-warning">
                                                    <i class="fa fa-star"></i >
                                                </div>
                                            </div>
                                        @endfor
                                        @for ($i = $rating->value + 1; $i <= 5; $i++)
                                                <div class="col">
                                                    <div class="ms-auto text-secondary">
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="mb-3">{{$rating->review}}</p>
                                <span class="border-bottom mb-3"></span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
