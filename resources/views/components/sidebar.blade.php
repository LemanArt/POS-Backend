<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">Warkop Titip Kopi</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">POS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main Menu</li>

            <li class='{{ Request::is("home") ? "active" : "" }}'>
                <a class="nav-link" href="{{ url('home') }}">
                    <i class="fas fa-desktop"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class='{{ Request::is("user*") ? "active" : "" }}'>
                <a class="nav-link" href="{{ route('user.index') }}">
                    <i class="fas fa-users"></i> <span>Users</span>
                </a>
            </li>

            <li class='{{ Request::is("product*") ? "active" : "" }}'>
                <a class="nav-link" href="{{ route('product.index') }}">
                    <i class="fas fa-box"></i> <span>Products</span>
                </a>
            </li>

            <li class='{{ Request::is("order*") ? "active" : "" }}'>
                <a class="nav-link" href="{{ route('order.index') }}">
                    <i class="fas fa-shopping-cart"></i> <span>Orders</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
