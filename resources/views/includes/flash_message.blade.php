@if(session()->has("message"))
    <div class="alert alert-danger text-center" id="flash-message" role="alert">
        <p class="alert-message">{{session("message")}}</p>
    </div>
@endif
