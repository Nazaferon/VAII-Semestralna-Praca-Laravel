@extends('layouts.header')

@section('content')
    @include('includes.top_side_nav_bar')
    <div class="container-fluid bottom-container">
        <div class="login-register-container">
            <h1>Prihlásiť</h1>
            <form method="post" action="/users/authenticate">
                @csrf
                <div class="mt-3">
                    <label>Email:</label>
                    <input type="email" class="form-control" name="email" placeholder="Zadajte email"
                           value="{{old("email")}}">
                </div>
                @error("email")
                <p class="text-danger">{{$message}}</p>
                @enderror
                <div class="mt-3">
                    <label>Heslo:</label>
                    <input type="password" class="form-control" name="password" placeholder="Zadajte heslo"
                           value="{{old("password")}}">
                </div>
                @error("password")
                <p class="text-danger">{{$message}}</p>
                @enderror
                <div class="form-check mt-3">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remember_me">Zapamätať si ma
                    </label>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Prihlásiť</button>
                <p class="mt-3">
                    Nemáte vytvorený účet?
                    <a href="/register">Registrovať</a>
                </p>
            </form>
        </div>
    </div>
@endsection
