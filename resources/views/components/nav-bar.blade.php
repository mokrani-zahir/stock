<nav class="navbar navbar-expand-lg mb-4 navbar-dark bg-dark">
    <div class="container-fluid p-3">
        <a class="navbar-brand" href="#">Gestion de stock</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ \route('bon') }}">Bon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ \route('mouvement') }}">Mouvement</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/logout">Déconnecter</a>
                </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
