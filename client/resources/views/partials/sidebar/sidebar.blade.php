<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'dashboard' ? 'active' : '' }} collapsed"
                href="{{ route('dashboard') }}">
                <i class="bi bi-house"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">Routes</li>

        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'routes.index' ? 'active' : '' }} collapsed"
                href="{{ route('routes.index') }}">
                <i class="bi bi-arrow-90deg-right"></i>
                <span>My Route</span>
            </a>
        </li>
    </ul>

</aside><!-- End Sidebar-->
