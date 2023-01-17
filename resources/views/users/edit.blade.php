@extends('layouts.header')

@section('content')
    <a id="back-to-top" href="#" class="btn btn-light btn-lg back-to-top" role="button"><i class="fa fa-chevron-up"></i></a>
    @include('includes.top_side_nav_bar')
    <div class="container-fluid bottom-container">
        @include('includes.flash_message')
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="card">
                    <header class="card-header">
                        <h4 class="title pt-2">Kontaktné údaje:</h4>
                    </header>
                    <div class="card-body">
                        <form method="post" action="/users/update/name">
                            @csrf
                            <div class="mb-3">
                                <label>Meno:</label>
                                <input type="text" class="form-control" name="new_firstname"
                                       value={{auth()->user()->firstname}}>
                                @error("new_firstname")
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Priezvisko:</label>
                                <input type="text" class="form-control" name="new_lastname"
                                       value={{auth()->user()->lastname}}>
                                @error("new_lastname")
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Upraviť</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <header class="card-header">
                                <h4 class="title pt-2">Zmena e-mailu:</h4>
                            </header>
                            <div class="card-body">
                                <form method="post" action="/users/update/email">
                                    @csrf
                                    <div class="mb-3">
                                        <label>Email:</label>
                                        <input type="email" class="form-control" name="new_email"
                                               value={{auth()->user()->email}}>
                                        @error("new_email")
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Upraviť</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <header class="card-header">
                                <h4 class="title pt-2">Zrušenie konta:</h4>
                            </header>
                            <div class="card-body">
                                <form method="post" onsubmit="return confirm('Naozaj chcete odstrániť svoj profil?');" action="/users/destroy">
                                    @csrf
                                    <div class="mb-3">
                                        <label>Umožňuje vám natrvalo odstrániť svoj účet a informácie.</label>
                                    </div>
                                    <button type="submit" class="btn btn-danger">Vymazať konto</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <header class="card-header">
                        <h4 class="title pt-2">Zmena hesla:</h4>
                    </header>
                    <div class="card-body">
                        <form method="post" action="/users/update/password">
                            @csrf
                            <div class="mb-3">
                                <label>Súčasné heslo:</label>
                                <input type="password" class="form-control" name="current_password"
                                       placeholder="Zadajte súčasné heslo" value="{{old("current_password")}}">
                                @error("current_password")
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3 mt-3">
                                <label>Nové heslo:</label>
                                <input type="password" class="form-control" name="new_password"
                                       placeholder="Zadajte nové heslo" value="{{old("new_password")}}">
                                @error("new_password")
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3 mt-3">
                                <label>Potvrdenie hesla:</label>
                                <input type="password" class="form-control" name="new_password_confirmation"
                                       placeholder="Znova zadajte nové heslo"
                                       value="{{old("new_password_confirmation")}}">
                                @error("new_password_confirmation")
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Upraviť</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
