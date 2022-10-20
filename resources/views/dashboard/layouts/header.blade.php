<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 text-center " href="/dashboard">SIMLAB</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <input class="form-control form-control-dark " type="text" placeholder disabled="true" style="background-color:rgba(24, 23, 23, 0.627);">
    <div class="navbar-nav">
      <div class="nav-item text-nowrap">
        <form action="/logout" method="post">
            @csrf
            <button type="submit" class="bg-dark text-light">Logout
                <span data-feather="log-out"></span> </button>
        </form>
      </div>
    </div>
</header>
