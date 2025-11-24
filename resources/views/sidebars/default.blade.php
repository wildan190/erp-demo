<div class="p-2 text-muted">
    <p class="small mb-1">Quick Links</p>
    <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
        <li class="nav-item"><a class="nav-link py-1" href="/dashboard"><i class="fas fa-home mr-2"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link py-1" href="/customers"><i class="fas fa-users mr-2"></i> All Customers</a></li>
        <li class="nav-item"><a class="nav-link py-1" href="/products"><i class="fas fa-boxes mr-2"></i> All Products</a></li>
        <li class="nav-item"><a class="nav-link py-1" href="/orders"><i class="fas fa-shopping-cart mr-2"></i> Recent Orders</a></li>
        <li class="nav-item"><a class="nav-link py-1" href="/invoices"><i class="fas fa-file-invoice mr-2"></i> Invoices</a></li>
        <li class="nav-item"><a class="nav-link py-1" href="/suppliers"><i class="fas fa-truck mr-2"></i> Suppliers</a></li>
        <li class="nav-item"><a class="nav-link py-1" href="/purchases"><i class="fas fa-receipt mr-2"></i> Purchases</a></li>
        <li class="nav-item"><a class="nav-link py-1" href="/reports"><i class="fas fa-chart-line mr-2"></i> Reports</a></li>
        <li class="nav-item"><a class="nav-link py-1" href="/settings"><i class="fas fa-cog mr-2"></i> Settings</a></li>
        @auth
        <li class="nav-item mt-2">
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="btn btn-outline-light btn-sm w-100" type="submit">Logout</button>
            </form>
        </li>
        @endauth
    </ul>
</div>
