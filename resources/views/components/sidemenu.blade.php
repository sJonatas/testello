
<!-- Sidebar scroll-->
<aside class="left-sidebar">
<div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="{{route('index')}}" class="text-nowrap logo-img">
            <img src="{{asset('assets/images/logos/logo.svg')}}" alt="" />
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-6"></i>
        </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            <li class="nav-small-cap">
                <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('clients.index') }}" aria-expanded="false">
                    <i class="ti ti-user-circle"></i>
                    <span class="hide-menu">Clientes</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('imported-files.index') }}" aria-expanded="false">
                    <i class="ti ti-file"></i>
                    <span class="hide-menu">Arquivos Importados</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>
<!-- End Sidebar scroll-->
</aside>
