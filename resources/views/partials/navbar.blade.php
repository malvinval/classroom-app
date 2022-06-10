<nav class="navbar bg-light fixed-top mb-5">
    <div class="container">
      <a class="navbar-brand text-success" href="/c">{{ env("APP_NAME") }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title text-success" id="offcanvasNavbarLabel">Hello, {{ auth()->user()->name }} !</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link {{ Route::is('home') ? 'text-success' : 'text-muted' }}" aria-current="page" href="/">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Route::is('classrooms') ? 'text-success' : 'text-muted' }}" aria-current="page" href="/c">Joined classroom</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Request::is('mc*') ? 'text-success' : 'text-muted' }}" aria-current="page" href="/mc">My classroom</a>
            </li>
          </ul>

          <form class="d-flex mb-2 mt-2" role="search" method="GET" action="/c">

            <input class="form-control me-2" name="search" type="search" placeholder="Search a classroom..." aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
          <form class="d-flex" method="POST" action="/join">
            @csrf
            <input class="form-control me-2" name="access_code" type="text" placeholder="Enter access token..." aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Join</button>
          </form>
          <form class="d-flex mt-3" action="/logout" method="POST">
            @csrf
            <button type="submit" class="logout-btn bg-transparent border-0">
              <p class="text-danger d-inline"><i class="bi bi-box-arrow-right"></i> Logout</p>
            </button>
          </form>
        </div>
      </div>
    </div>
</nav>