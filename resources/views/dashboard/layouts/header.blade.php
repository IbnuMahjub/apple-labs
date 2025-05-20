<header class="top-header">
  <nav class="navbar navbar-expand align-items-center gap-4">
    <div class="btn-toggle">
      <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
    </div>
    <div class="search-bar flex-grow-1">
      <div class="position-relative">
        <input class="form-control rounded-5 px-5 search-control d-lg-block d-none" type="text" placeholder="Search">
        <span class="material-icons-outlined position-absolute d-lg-block d-none ms-3 translate-middle-y start-0 top-50">search</span>
        <span class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 search-close">close</span>
        <div class="search-popup p-3">
          <div class="card rounded-4 overflow-hidden">
            <div class="card-header d-lg-none">
              <div class="position-relative">
                <input class="form-control rounded-5 px-5 mobile-search-control" type="text" placeholder="Search">
                <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50">search</span>
                <span class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 mobile-search-close">close</span>
               </div>
            </div>
            <div class="card-body search-content">
              <p class="search-title">Recent Searches</p>
              <div class="d-flex align-items-start flex-wrap gap-2 kewords-wrapper">
                <a href="javascript:;" class="kewords"><span>Angular Template</span><i
                    class="material-icons-outlined fs-6">search</i></a>
                <a href="javascript:;" class="kewords"><span>Dashboard</span><i
                    class="material-icons-outlined fs-6">search</i></a>
                <a href="javascript:;" class="kewords"><span>Admin Template</span><i
                    class="material-icons-outlined fs-6">search</i></a>
                <a href="javascript:;" class="kewords"><span>Bootstrap 5 Admin</span><i
                    class="material-icons-outlined fs-6">search</i></a>
                <a href="javascript:;" class="kewords"><span>Html eCommerce</span><i
                    class="material-icons-outlined fs-6">search</i></a>
                <a href="javascript:;" class="kewords"><span>Sass</span><i
                    class="material-icons-outlined fs-6">search</i></a>
                <a href="javascript:;" class="kewords"><span>laravel 9</span><i
                    class="material-icons-outlined fs-6">search</i></a>
              </div>
              <hr>
              <p class="search-title">Tutorials</p>
              <div class="search-list d-flex flex-column gap-2">
                <div class="search-list-item d-flex align-items-center gap-3">
                  <div class="list-icon">
                    <i class="material-icons-outlined fs-5">play_circle</i>
                  </div>
                  <div class="">
                    <h5 class="mb-0 search-list-title ">Wordpress Tutorials</h5>
                  </div>
                </div>
                <div class="search-list-item d-flex align-items-center gap-3">
                  <div class="list-icon">
                    <i class="material-icons-outlined fs-5">shopping_basket</i>
                  </div>
                  <div class="">
                    <h5 class="mb-0 search-list-title">eCommerce Website Tutorials</h5>
                  </div>
                </div>

                <div class="search-list-item d-flex align-items-center gap-3">
                  <div class="list-icon">
                    <i class="material-icons-outlined fs-5">laptop</i>
                  </div>
                  <div class="">
                    <h5 class="mb-0 search-list-title">Responsive Design</h5>
                  </div>
                </div>
              </div>

              <hr>
              <p class="search-title">Members</p>

              <div class="search-list d-flex flex-column gap-2">
                <div class="search-list-item d-flex align-items-center gap-3">
                  <div class="memmber-img">
                    <img src="{{ asset('vertical/assets/images/avatars/01.png') }}" width="32" height="32" class="rounded-circle" alt="">
                  </div>
                  <div class="">
                    <h5 class="mb-0 search-list-title ">Andrew Stark</h5>
                  </div>
                </div>

                <div class="search-list-item d-flex align-items-center gap-3">
                  <div class="memmber-img">
                    <img src="{{ asset('vertical/assets/images/avatars/02.png') }}" width="32" height="32" class="rounded-circle" alt="">
                  </div>
                  <div class="">
                    <h5 class="mb-0 search-list-title ">Snetro Jhonia</h5>
                  </div>
                </div>

                <div class="search-list-item d-flex align-items-center gap-3">
                  <div class="memmber-img">
                    <img src="assets/images/avatars/03.png" width="32" height="32" class="rounded-circle" alt="">
                  </div>
                  <div class="">
                    <h5 class="mb-0 search-list-title">Michle Clark</h5>
                  </div>
                </div>

              </div>
            </div>
            <div class="card-footer text-center bg-transparent">
              <a href="javascript:;" class="btn w-100">See All Search Results</a>
            </div>
          </div>
        </div>
      </div>
    </div>
        </div>
      </li>
      
      {{-- modal absen --}}
       <li class="nav-item d-md-flex d-none">
        <a class="nav-link position-relative btn"  data-bs-toggle="modal"
        data-bs-target="#FormModal">
          <i class="material-icons-outlined">access_alarm</i>
        </a>
      </li>

      <li class="nav-item dropdown">
        <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
           <img src="{{ !empty(session('user')['avatar']) ? session('user')['avatar'] : asset('vertical/assets/images/avatars/11.png') }}" class="rounded-circle p-1 border" width="45" height="45" alt="">
        </a>
        <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
          <a class="dropdown-item  gap-2 py-2" href="/profile">
            <div class="text-center">
              <img src="{{ !empty(session('user')['avatar']) ? session('user')['avatar'] : asset('vertical/assets/images/avatars/11.png') }}" class="rounded-circle p-1 shadow mb-3" width="90" height="90"
                alt="">
              <h5 class="user-name mb-0 fw-bold">Hello, </h5>
            </div>
          </a>
          <hr class="dropdown-divider">
          <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
            class="material-icons-outlined">person_outline</i>Profile</a>
          @if (auth()->user()->is_admin)
          <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="/company"><i
            class="material-icons-outlined">account_balance</i>Company</a>
          @endif
          <hr class="dropdown-divider">
          <form action="/logout" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 border-0 bg-transparent" style="cursor: pointer;">
                  <i class="material-icons-outlined">power_settings_new</i>Logout
              </button>
          </form>

        </div>
      </li>
    </ul>

  </nav>
</header>

<div class="modal fade" id="FormModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-bottom-0 py-2 bg-grd-info">
        <h5 class="modal-title">Form Absensi</h5>
        <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
          <i class="material-icons-outlined">close</i>
        </a>
      </div>
      <div class="modal-body">
        <div class="form-body">
          <div class="text-center my-2">
            <h4 id="jamSekarang" style="font-weight: bold;"></h4>
          </div>
          
          <form id="absensiForm" class="row g-3">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
          
            <div class="col-md-12">
              <label for="absenType" class="form-label">Absen</label>
              <select id="absenType" name="tipe_absen" class="form-select">
                <option value="in">Clock In</option>
                <option value="out">Clock Out</option>
              </select>
            </div>
          
            <div class="col-md-12 d-md-flex d-grid align-items-center gap-3">
              <button type="submit" class="btn btn-grd-danger px-4">Submit</button>
              <button type="reset" class="btn btn-grd-info px-4">Reset</button>
            </div>
          </form>
          

        </div>
      </div>
    </div>
  </div>
</div>
