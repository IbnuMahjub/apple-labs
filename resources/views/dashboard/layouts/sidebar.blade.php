<aside class="sidebar-wrapper" data-simplebar="true">
  <div class="sidebar-header">
    <a href="/" class="logo-icon">
      <img src="{{ asset('vertical/assets/images/logo-icon.png') }}" class="logo-img" alt="">
    </a>
    <a href="/" class="logo-name flex-grow-1">
      <h5 class="mb-0">Property</h5>
    </a>
    <div class="sidebar-close">
      <span class="material-icons-outlined">close</span>
    </div>
  </div>
  
  <div class="sidebar-nav">
    <ul class="metismenu" id="sidenav">
      <li class="{{ request()->is('dashboard') || request()->is('profile') ? 'mm-active' : '' }}">
        <a href="/dashboard">
          <div class="parent-icon"><i class="material-icons-outlined">home</i></div>
          <div class="menu-title">Dashboard</div>
        </a>
      </li>
      @can('admin')
      <li class="menu-label">Administrator</li>
      <li class="{{ request()->is('property*') || request()->is('category*') || request()->is('unit*') ? 'mm-active' : '' }}">
        <a href="javascript:;" class="has-arrow">
          <div class="parent-icon"><i class="material-icons-outlined">description</i></div>
          <div class="menu-title">Master Data</div>
        </a>
        <ul class="{{ request()->is('data-absensi*') || request()->is('karyawan*') || request()->is('data-artikel*') ? 'mm-show' : '' }}">
          <li class="{{ request()->is('karyawan*') ? 'active' : '' }}">
            <a href="/karyawan"><i class="material-icons-outlined">person</i>karyawan</a>
          </li>
          <li class="{{ request()->is('data-absensi*') ? 'active' : '' }}">
            <a href="/data-absensi"><i class="material-icons-outlined">room_preferences</i>data-absensi</a>
          </li>
          <li class="{{ request()->is('data-artikel*') ? 'active' : '' }}">
            <a href="/data-artikel"><i class="material-icons-outlined">article</i>Articel</a>
          </li>
        </ul>     
      </li>
      @endcan
      <li class="">
        <a href="/data-kehadiran">
          <div class="parent-icon"><i class="material-icons-outlined">data_thresholding</i></div>
          <div class="menu-title">Data Kehadiran</div>
        </a>
      </li>
    </ul>
  </div>
</aside>