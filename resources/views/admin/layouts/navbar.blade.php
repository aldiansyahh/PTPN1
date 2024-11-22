<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item dropdown no-arrow flex d-flex">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" aria-haspopup="true"
                aria-expanded="false">
                <i class="fa fa-user"></i> {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in px-10 mt-2"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('actionlogout') }}">
                    <img src="{{ asset('assets/img/logout.png') }}" class="img-fluid" style="width: 20px; height: auto;"
                        alt="Logout"> &ensp; Logout
                </a>
            </div>
        </li>



    </ul>
</nav>
<!-- /.navbar -->
