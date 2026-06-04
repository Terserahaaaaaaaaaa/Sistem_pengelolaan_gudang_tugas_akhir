<aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="index.html" aria-label="adminHMD dashboard">
          <div class="sidebar-header">
              <a class="brand-mark" href="/admin" aria-label="Dashboard">

                  <img src="{{ asset('template/assets/img/logo-perusahaan.png') }}"
                      alt="Logo"
                      width="45"
                      height="45">

                  <span class="brand-copy">
                      <span class="brand-title">SISTEM GUDANG</span>
                      <span class="brand-subtitle">PT Muara Kayu Sengon</span>
                  </span>

              </a>
          </div>
      <nav class="sidebar-nav">
        <a class="nav-link active" href="{{ route('home') }}" aria-current="page">
          <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
          <span class="nav-text">Dashboard</span>
        </a>

        <a class="nav-link" href="users.html">
          <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
          <span class="nav-text">Users</span>
        </a>

         <a class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}" href="{{ route('barang.index') }}">
            <span class="nav-icon">
                <i class="bi bi-box-seam"></i>
            </span>
            <span class="nav-text">Barang</span>
        </a>

        <a class="nav-link {{ request()->routeIs('stok-barang.*') ? 'active' : '' }}" href="{{ route('stok-barang.index') }}">
            <span class="nav-icon">
                <i class="bi bi-boxes"></i>
            </span>
            <span class="nav-text">Stok Barang</span>
        </a>

        <a class="nav-link {{ request()->routeIs('barang-masuk.*') ? 'active' : '' }}" href="{{ route('barang-masuk.index') }}">
            <span class="nav-icon">
                <i class="bi bi-box-arrow-in-down"></i>
            </span>
            <span class="nav-text">Barang Masuk</span>
        </a>

        <a class="nav-link {{ request()->routeIs('barang-keluar.*') ? 'active' : '' }}" href="{{ route('barang-keluar.index') }}">
            <span class="nav-icon">
                <i class="bi bi-box-arrow-up"></i>
            </span>
            <span class="nav-text">Barang Keluar</span>
        </a>

        <a class="nav-link {{ request()->routeIs('permintaan-barang.*') ? 'active' : '' }} "href="{{ route('permintaan-barang.index') }}">
            <span class="nav-icon">
                <i class="bi bi-clipboard-check"></i>
            </span>
            <span class="nav-text">Permintaan Barang</span>
        </a>

        <a class="nav-link {{ request()->routeIs('pengajuan-po.*') ? 'active' : '' }}" href="{{ route('pengajuan-po.index') }}">
            <span class="nav-icon">
                <i class="bi bi-file-earmark-text"></i>
            </span>
            <span class="nav-text">Pengajuan PO</span>
        </a>

        <a class="nav-link {{ request()->routeIs('approval_po.*') ? 'active' : '' }}" href="{{ route('approval_po.index') }}">
            <span class="nav-icon">
                <i class="bi bi-file-earmark-text"></i>
            </span>
            <span class="nav-text">Data Pengajuan PO</span>
        </a>
        
        <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
            <span class="nav-icon">
                <i class="bi bi-file-bar-graph"></i>
            </span>
            <span class="nav-text">Laporan</span>
        </a>

        {{-- @if(auth()->user()->role == 'admin_gudang') --}}
        <a class="nav-link {{ request()->routeIs('daftar-permintaan.*') ? 'active' : '' }} "href="{{ route('daftar-permintaan.admin_index') }}">
            <span class="nav-icon">
                <i class="bi bi-inbox"></i>
            </span>
            <span class="nav-text">Permintaan Masuk</span>
        </a>
        {{-- @endif --}}
      </nav>

      <div class="sidebar-user">
        <img class="avatar-img avatar-md sidebar-user-avatar" src="../template/assets/images/avatar/avatar.jpg" alt="Admin Hasan">
        <strong>Admin Hasan</strong>
        <small>Active Workspace</small>
      </div>
    </aside>