<div class="sidebar bg-dark text-white p-3">
    <div class="d-flex align-items-center mb-4">
        <i class="bi bi-box-seam-fill fs-3 me-2"></i>
        <h4 class="mb-0">Inventaris Pro</h4>
    </div>
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('barang.index') }}" class="nav-link text-white {{ request()->routeIs('barang.index') ? 'active' : '' }}">
                <i class="bi bi-grid-fill me-2"></i> Daftar Barang
            </a>
        </li>

        @if(auth()->user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('barang.masuk') }}" class="nav-link text-white {{ request()->routeIs('barang.masuk') ? 'active' : '' }}">
                <i class="bi bi-arrow-down-square-fill me-2"></i> Barang Masuk
            </a>
        </li>

<li class="nav-item">
    <a href="{{ route('barang.keluar') }}" class="nav-link text-white {{ request()->routeIs('barang.keluar') ? 'active' : '' }}">
        <i class="bi bi-arrow-up-square-fill me-2"></i> Barang Keluar
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('kategori.index') }}" class="nav-link text-white {{ request()->routeIs('kategori.index') ? 'active' : '' }}">
        <i class="bi bi-tags-fill me-2"></i> Kategori
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('supplier.index') }}" class="nav-link text-white {{ request()->routeIs('supplier*') ? 'active' : '' }}">
        <i class="bi bi-truck me-2"></i> Supplier
    </a>
</li>

        <li class="nav-item">
            <a href="{{ route('laporan.index') }}" class="nav-link text-white {{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph-fill me-2"></i> Laporan
            </a>
        </li>
        @endif
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-4 me-2"></i>
            <strong>{{ Auth::user()->name }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                        Sign out
                    </a>
                </form>
            </li>
        </ul>
    </div>
</div>