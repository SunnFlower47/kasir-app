      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="../index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="../../../dist/assets/img/AdminLTELogo.png"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Kasir App</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Dashboard
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href={{ route('admin.dashboard') }} class=" nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : ''  }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Dashboard admin</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('kasir.dashboard') }}" class="nav-link {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Dashboard kasir</p>
                    </a>
                    </li>
                  <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Dashboard</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.barang.index') }}" class="nav-link {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-box"></i>
                  <p>Barang</p>
                </a>
              </li>
                <li class="nav-item">
                    <a href="{{ route('admin.distributor.index') }}" class="nav-link {{ request()->routeIs('admin.distributor.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-truck"></i>
                    <p>Distributor</p>
                    </a>
                </li>
              <li class="nav-item">
                <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-tags"></i>
                  <p>Kategori</p>
                </a>
              </li>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
