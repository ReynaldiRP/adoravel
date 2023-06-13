<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    @include('includes.style')
    @stack('styles')
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="sidebar no-scrollbar pe-4 pb-3">
            <nav class="navbar  bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand sticky mx-4 mb-3">
                    <h4 class="text-primary">
                        adoravelpetcare
                    </h4>
                </a>
                <div class="d-flex sticky align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="{{ asset('img/profile.png') }}" alt=""
                            style="width: 40px; height: 40px" />
                        <div
                            class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                        </div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Michael</h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav  w-100">
                    <a href="{{ route('dashboard') }}"
                        class="nav-item nav-link {{ request()->is('dashboard') ? ' active' : '' }}"><i
                            class="fa-solid fa-gauge me-2"></i>Dashboard</a>
                    <a href="{{ route('petOwner.index') }}"
                        class="nav-item nav-link{{ request()->is('petOwner*') ? ' active' : '' }}">
                        <i class="fa-solid fa-user me-2"></i>Pet Owner
                    </a>
                    <a href="{{ route('employee.index') }}"
                        class="nav-item nav-link{{ request()->is('employee*') ? ' active' : '' }}"><i
                            class="fa-solid fa-user-pen me-2"></i>Pegawai</a>
                    <a href="{{ route('petRegistration.index') }}"
                        class="nav-item nav-link{{ request()->is('petRegistration*') ? ' active' : '' }} "><i
                            class="fa-solid fa-cat me-2"></i>Pet Registration</a>
                    <a href="{{ route('servicePet.index') }}"
                        class="nav-item nav-link{{ request()->is('servicePet*') ? ' active' : '' }}"><i
                            class="fa-solid fa-droplet me-2"></i>Layanan</a>
                    <a href="{{ route('petFood.index') }}"
                        class="nav-item nav-link{{ request()->is('petFood*') ? ' active' : '' }}"><i
                            class="fas fa-bone me-2"></i>Makanan</a>
                    <a href="{{ route('transaction.index') }}"
                        class="nav-item nav-link{{ request()->is('transaction*') ? ' active' : '' }}"><i
                            class="far fa-file-alt  me-2"></i>Transaksi</a>
                    <a href="{{ route('detail_transaction.index') }}"
                        class="nav-item nav-link{{ request()->is('detail_transaction*') ? ' active' : '' }}"><i
                            class="fas fa-sticky-note me-2"></i>Detail
                        Transaksi</a>
                </div>
            </nav>
        </div>
        <div class="content">
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href=".dropdown-menu" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="{{ asset('img/profile.png') }}" alt=""
                                style="width: 40px; height: 40px" />
                            <span class="d-none d-lg-inline-flex">Michael</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <form id="logout_form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a href="javascript:{}" onclick="document.getElementById('logout_form').submit();"
                                    class="dropdown-item">Log
                                    Out</a>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="container-fluid pt-4 px-3">
                <div class="row g-4">
                    <div>
                        <div class="bg-secondary rounded h-100 p-4">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid pt-4 px-3">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">adoravelpetcare</a>, All Right Reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.script')
    @stack('script')
</body>

</html>
