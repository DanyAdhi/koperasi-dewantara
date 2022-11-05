@php
  $url = request()->segment(1);
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="#" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="{{asset('img/handayani.png')}}" alt="" style="width: 40px">
      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2">Koperasi</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{($url=='dashboard' || $url==null)?'active':''}}">
      <a href="{{url('/')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <li class="menu-item {{($url=='users') ? 'active' : ''}}">
      <a href="{{url('/users')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user-circle"></i>
        <div data-i18n="Analytics">Users</div>
      </a>
    </li>
    <li class="menu-item {{($url=='loans') ? 'active' : ''}}">
      <a href="{{url('/loans')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-bank"></i>
        <div data-i18n="Analytics">Pinjaman</div>
      </a>
    </li>

  </ul>
</aside>