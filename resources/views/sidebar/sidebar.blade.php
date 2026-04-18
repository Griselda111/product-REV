<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 my-2 bg-white" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-4 d-flex align-items-center py-3 m-3" href="#">
      <img src="{{ asset('assets/img/BPTTG_DIY-removebg-preview.png') }}" class="navbar-brand-img h-100 me-2" alt="Logo">
      <img src="{{ asset('assets/img/BPTTG DIY word.png') }}" class="navbar-brand-img h-100" alt="Logo Text">
    </a>
  </div>

  <hr class="horizontal dark mt-0 mb-2">

  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder text-dark opacity-8">Home</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard') ? 'active bg-gradient-dark text-white' : '' }}" 
           href="{{ route('dashboard') }}" 
           style="{{ !Request::is('dashboard') ? 'color: #344767 !important;' : '' }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10" style="{{ Request::is('admin/dashboard') ? 'color: #ffffff !important;' : 'color: #344767 !important;' }}">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder text-dark opacity-8">Data</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Request::is('biaya-jasa*') ? 'active bg-gradient-dark text-white' : '' }}" 
           href="{{ route('BiayaJasa.index') }}"
           style="{{ !Request::is('biaya-jasa*') ? 'color: #344767 !important;' : '' }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10" style="{{ Request::is('/biaya-jasa*') ? 'color: #ffffff !important;' : 'color: #344767 !important;' }}">folder</i>
          </div>
          <span class="nav-link-text ms-1">Data Biaya Jasa</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Request::is('customers*') ? 'active bg-gradient-dark text-white' : '' }}" 
           href="{{ route('customers.index') }}"
           style="{{ !Request::is('customers*') ? 'color: #344767 !important;' : '' }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10" style="{{ Request::is('/customers*') ? 'color: #ffffff !important;' : 'color: #344767 !important;' }}">group</i>
          </div>
          <span class="nav-link-text ms-1">Customer</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder text-dark opacity-8">Proses</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Request::is('orders*') ? 'active bg-gradient-dark text-white' : '' }}" 
           href="{{ route('orders.index') }}"
           style="{{ !Request::is('orders*') ? 'color: #344767 !important;' : '' }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10" style="{{ Request::is('/orders*') ? 'color: #ffffff !important;' : 'color: #344767 !important;' }}">shopping_cart</i>
          </div>
          <span class="nav-link-text ms-1">Order</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder text-dark opacity-8">Logout</h6>
      </li>

      <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="nav-link bg-transparent border-0 w-100 text-start" style="color: #344767 !important;">
            <i class="material-symbols-rounded" style="color: #344767 !important;">logout</i>
            <span class="nav-link-text ms-1">Log out</span>
          </button>
        </form>
      </li>
    </ul>
  </div>
</aside>
