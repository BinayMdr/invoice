<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{route('dashboard')}}">
        <span class="ms-1 font-weight-bold text-white">{{$settings->value}}</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      @php
        $currentRoute = \Route::currentRouteName();
      @endphp
      <ul class="navbar-nav">
        {{-- <li class="nav-item">
          <a class="nav-link text-white @if($currentRoute == "dashboard") active @endif" href="{{route('dashboard')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li> --}}
        @if(\Auth::user()->hasRole('view-groups') || \Auth::user()->hasRole('view-users'))
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">User & Roles</h6>
          </li>
        @endif
        @if(\Auth::user()->hasRole('view-users'))
          <li class="nav-item">
            <a class="nav-link text-white @if(str_contains(url()->current(),'user')) active @endif" href="{{route('user')}}">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">groups</i>
              </div>
              <span class="nav-link-text ms-1">User</span>
            </a>
          </li>
        @endif
        @if(\Auth::user()->hasRole('view-groups'))
          <li class="nav-item">
            <a class="nav-link text-white @if(str_contains(url()->current(),'group')) active @endif" href="{{route('group')}}">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">groups</i>
              </div>
              <span class="nav-link-text ms-1">Group</span>
            </a>
          </li>
        @endif

        @if(\Auth::user()->hasRole('view-about-us') || \Auth::user()->hasRole('view-teams'))
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Pages</h6>
          </li>
        @endif
       
        @if(\Auth::user()->hasRole('view-about-us'))
        <li class="nav-item">
          <a class="nav-link text-white @if(str_contains(url()->current(),'about-us')) active @endif" href="{{route('about-us')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">info</i>
            </div>
            <span class="nav-link-text ms-1">About Us</span>
          </a>
        </li>
        @endif
        @if(\Auth::user()->hasRole('view-teams'))
        <li class="nav-item">
          <a class="nav-link text-white @if(str_contains(url()->current(),'team')) active @endif" href="{{route('team')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">people</i>
            </div>
            <span class="nav-link-text ms-1">Team</span>
          </a>
        </li>
        @endif

        @if(\Auth::user()->hasRole('view-banners') || \Auth::user()->hasRole('view-pop-ups') 
        || \Auth::user()->hasRole('view-products') || \Auth::user()->hasRole('view-ceritifcations'))
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Image Related</h6>
        </li>
        @endif

        @if(\Auth::user()->hasRole('view-banners'))
          <li class="nav-item">
            <a class="nav-link text-white @if(str_contains(url()->current(),'banner')) active @endif" href="{{route('banner')}}">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">wallpaper</i>
              </div>
              <span class="nav-link-text ms-1">Banner</span>
            </a>
          </li>
        @endif
       
        
        
        @if(\Auth::user()->hasRole('view-pop-ups'))
          <li class="nav-item">
            <a class="nav-link text-white @if(str_contains(url()->current(),'pop-up')) active @endif" href="{{route('pop-up')}}">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">photo_library</i>
              </div>
              <span class="nav-link-text ms-1">Pop Up</span>
            </a>
          </li>
        @endif
      
        @if(\Auth::user()->hasRole('view-products'))
        <li class="nav-item">
          <a class="nav-link text-white @if(\Request::route()->getName() == "product") active @endif" href="{{route('product')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">inventory</i>
            </div>
            <span class="nav-link-text ms-1">Product</span>
          </a>
        </li>
        @endif
        
        @if(\Auth::user()->hasRole('view-certifications'))
        <li class="nav-item">
          <a class="nav-link text-white @if(\Request::route()->getName() == "certification") active @endif" href="{{route('certification')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">workspace_premium</i>
            </div>
            <span class="nav-link-text ms-1">Certification</span>
          </a>
        </li>
        @endif

        @if(\Auth::user()->hasRole('view-customer-reviews') || \Auth::user()->hasRole('view-messages'))
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Other</h6>
          </li>
        @endif
       

        @if(\Auth::user()->hasRole('view-customer-reviews'))
        <li class="nav-item">
          <a class="nav-link text-white @if(str_contains(url()->current(),'customer-review')) active @endif" href="{{route('customer-review')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">reviews</i>
            </div>
            <span class="nav-link-text ms-1">Customer Reviews</span>
          </a>
        </li>
        @endif

        @if(\Auth::user()->hasRole('view-messages'))
        <li class="nav-item">
          <a class="nav-link text-white @if(str_contains(url()->current(),'message')) active @endif" href="{{route('message')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">message</i>
            </div>
            <span class="nav-link-text ms-1">Message</span>
          </a>
        </li>
        @endif

        @if(\Auth::user()->hasRole('view-settings'))
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Settings</h6>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white @if(\Request::route()->getName() == "setting") active @endif" href="{{route('setting')}}">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">settings</i>
              </div>
              <span class="nav-link-text ms-1">Setting</span>
            </a>
          </li>
        @endif
       
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if($currentRoute == "profile") active @endif" href="{{route('profile')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="{{route('logout')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">logout</i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>