@extends('layouts.header')

@section('content')
    @include('includes.top_side_nav_bar')
    <div class="container-fluid bottom-container">
        @include('includes.flash_message')
        <h3 class="text-center mt-1 mb-3">Zoznam prianí</h3>
        <div class="wishlists-container">
            <div class="d-flex flex-row align-items-center border-bottom border-top py-3">
                <div class="col mt-1">
                    <h5>Počet položiek: {{$wishlists->count()}}</h5>
                </div>
                <div class="col-auto col-sm-auto mt-1">
                    <h5>Cena</h5>
                </div>
            </div>
            <div id="table">
                @php $priceSum = 0 @endphp
                @foreach ($wishlists as $wishlist)
                    @php $priceSum += $wishlist->item->price @endphp
                        <div class="row align-items-center">
                            <div class="col-2">
                                <a class="text-reset text-decoration-none" href="/items/show/{{$wishlist->item->id}}">
                                    <img src="{{asset("storage/images/items/" . $wishlist->item->image_path)}}" class="py-3 w-100" alt="Image"/>
                                </a>
                            </div>
                            <div class="col">
                                <a class="text-reset text-decoration-none" href="/items/show/{{$wishlist->item->id}}">
                                    <h5>{{$wishlist->item->brand . " " . $wishlist->item->model}}</h5>
                                    <p class="mb-2">{{$wishlist->item->category}}</p>
                                    <p class="mb-0">Na sklade: <span class="fw-bold">{{$wishlist->item->amount}}</span>
                                </a>
                            </div>
                            <div class="col-1">
                                <div class="d-flex flex-row justify-content-end">
                                    <h5>€{{$wishlist->item->price}}</h5>
                                </div>
                                <div class="d-flex flex-row justify-content-end">
                                    <div class="col px-3">
                                        <form action="/shopping-basket/store/{{$wishlist->id}}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-success rounded-pill" style="text-align: center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Pridať do košíka">
                                                <i class="fa fa-plus pb-0" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col">
                                        <form action="/wishlists/destroy/{{$wishlist->id}}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger rounded-pill" style="text-align: center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Odstrániť zo zoznamu želaní">
                                                <i class="fa fa-times pb-0" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <span class="border-bottom"></span>
                        </div>
                @endforeach
            </div>
            <div class="row align-items-center border-bottom mt-1 py-3">
                <div class="col">
                    <h5>Cena spolu:</h5>
                </div>
                <div class="col-auto col-sm-auto">
                    <h5>€{{$priceSum}}</h5>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <form action="/shopping-basket/store-all" method="post">
                    @csrf
                    @foreach ($wishlists as $wishlist)
                        <input type="hidden" name="item_id_all[]" value="{{$wishlist->item->id}}">
                    @endforeach
                    <button type="submit" class="btn btn-success rounded-pill mt-3" style="text-align: center;">
                        <h5><i class="fa fa-shopping-cart pt-2" aria-hidden="true"></i> Vložiť všetko do nákupného košíka</h5>
                    </button>
                </form>
            </div>
                <div class="mt-3">

                    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                        <div>
                            <p class="small text-muted">
                                Showing
                                <span class="fw-semibold">7</span>
                                to
                                <span class="fw-semibold">8</span>
                                of
                                <span class="fw-semibold">8</span>
                                results
                            </p>
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link disabled" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
@endsection
