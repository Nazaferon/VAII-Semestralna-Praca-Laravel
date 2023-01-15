@extends('layouts.header')

@section('content')
    @include('includes.top_side_nav_bar')
    <div class="container-fluid bottom-container">
        <div class="login-register-container">
            <h1>Registrácia nového účtu v e-shope</h1>
            <form method="post" action="/users/store">
                @csrf
                <div class="mt-3">
                    <label>Meno:</label>
                    <input type="text" class="form-control" name="firstname" placeholder="Zadajte meno"
                           value="{{old("firstname")}}">
                    @error("firstname")
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Priezvisko:</label>
                    <input type="text" class="form-control" name="lastname" placeholder="Zadajte priezvisko"
                           value="{{old("lastname")}}">
                    @error("lastname")
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Email:</label>
                    <input type="email" class="form-control" name="email" placeholder="Zadajte email"
                           value="{{old("email")}}">
                    @error("email")
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Heslo:</label>
                    <input type="password" class="form-control" name="password" placeholder="Zadajte heslo"
                           value="{{old("password")}}">
                    @error("password")
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Potvrdenie hesla:</label>
                    <input type="password" class="form-control" name="password_confirmation"
                           placeholder="Opakujte heslo" value="{{old("password_confirmation")}}">
                    @error("password_confirmation")
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3">Registrovať</button>
            </form>
        </div>
    </div>
@endsection
