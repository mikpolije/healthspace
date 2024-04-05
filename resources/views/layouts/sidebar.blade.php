<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{url('/')}}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{asset('login_assets/img/hslogo.png')}}" alt="" width="25" height="25" class="my-3">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2"> Health Space</span>
        </a>

        <a href="{{url('/')}}" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        @if(auth()->user()->role == 'admin')
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin/dashboard') ? 'active' : ''  }}">
            <a href="{{url('admin/dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin/daftar-pasien') ? 'active' : ''  }} ">
            <a href="{{url('admin/daftar-pasien')}}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Daftar Pasien</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('admin/invoice') ? 'active' : ''  }} ">
            <a href="{{url('admin/invoice')}}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div>Daftar Invoice</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('admin/daftar-konsultasi') ? 'active' : ''  }} ">
            <a href="{{url('admin/daftar-konsultasi')}}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div>List Konsultasi</div>
            </a>
        </li>


        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin/dokter') ? 'active' : ''  }} ">
            <a href="{{url('admin/dokter')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-git-repo-forked"></i>
                <div>Dokter</div>
            </a>
        </li>

        @endif

        @if(auth()->user()->role == 'pasien')
        <li class="menu-item {{ request()->is('pasien/dashboard') ? 'active' : ''  }}">
            <a href="{{url('pasien/dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('pasien/konsultasi') ? 'active' : ''  }}">
            <a href="{{url('pasien/konsultasi')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-chat"></i>
                <div>Konsultasi</div>
            </a>
        </li>
        @endif
        @if(auth()->user()->role == 'dokter')

        <li class="menu-item {{ request()->is('dokter/dashboard') ? 'active' : ''  }}">
            <a href="{{url('dokter/dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('dokter/konsultasi') ? 'active' : ''  }} ">
            <a href="{{url('dokter/konsultasi')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-chat"></i>
                <div>Chat Pasien</div>
            </a>
        </li>

    
        @endif


    </ul>
</aside>
