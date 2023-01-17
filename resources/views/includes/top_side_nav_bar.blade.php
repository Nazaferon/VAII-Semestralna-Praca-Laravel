<nav class="navbar top-navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
    <div class="container-fluid justify-content-around">
        <a class="navbar-brand" href="/">
            <img src={{asset("images/logos/large_logo.png")}} alt="Logo">
        </a>
        <form class="d-flex description-form" action="/">
            <input class="form-control" name="search" placeholder="Zadajte popis gitary">
            <button class="btn btn-primary" type="submit">Hľadať</button>
        </form>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link action-logo" href="/wishlists">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link action-logo" href="/shopping-basket">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                </a>
            </li>
            <li class="nav-item" style="display:inline-block;">
                @auth
                    <div class="dropdown">
                        <a class="nav-link action-logo" id="dropdownMenu" type="button" data-bs-toggle="dropdown"  aria-expanded="false" href="#">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <u class="profile-tags">{{auth()->user()->firstname[0] . auth()->user()->lastname[0]}}</u>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <li><a class="dropdown-item" href="/users/edit">Osobný profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><form class="inline" method="post" action="/users/logout">
                                     @csrf
                                    <button class="dropdown-item" type="submit">
                                        <i class="fa-solid fa-door-open" aria-hidden="true"></i>Odhlásiť
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="nav-link action-logo" href="/users/login">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="profile-tags">Prihlásenie</span>
                    </a>
                @endauth
            </li>
        </ul>
    </div>
</nav>
