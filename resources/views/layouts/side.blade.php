<div class="min-height-300 bg-dark position-absolute w-100"></div>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="#" target="_blank">
            <img src="{{ asset('img/logo_cmh.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">CMPHO - MFCIMS</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('dashboard')) ? 'active' : '' }}" href="{{ url('dashboard') }}">
                    <div
                        class="icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-gauge-high text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('charge*')) ? 'active' : '' }}" href="{{ url('charge') }}">
                    <div
                        class="icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-list-check text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">ข้อมูลลูกหนี้</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('create*')) ? 'active' : '' }}" href="{{ url('create') }}">
                    <div
                        class="icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-edit text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">บันทึกข้อมูลลูกหนี้</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('paid*')) ? 'active' : '' }}" href="{{ url('paid') }}">
                    <div
                        class="icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-comment-dollar text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">ข้อมูลเจ้าหนี้</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <div
                        class="icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-circle-info text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">คู่มือการใช้งาน</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
