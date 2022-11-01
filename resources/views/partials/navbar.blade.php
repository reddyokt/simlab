<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container ">
    <a class="navbar-brand" href="#">SIMLAB</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link {{ ($title === "Beranda") ? 'active' : '' }}" href="/">Beranda</a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto ">
            @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Welcome Back, {{ auth()->users()->username }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#">My Dashboard</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
              </li>
            @else
                    <li class="nav-item ">
                        <a href="/login" class="nav-link {{ ($title === "Login") ? 'active' : '' }} px-3 fw-bold " style="background-color: #ff0000;">
                        <i class="bi bi-box-arrow-in-right px-2"></i>Logisn</a>
                    </li>
            @endauth
        </ul>

    </div>
  </div>
</nav>
