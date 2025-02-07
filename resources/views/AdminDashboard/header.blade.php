<!-- Page Header Start-->
<div class="page-header">
    <div class="header-wrapper row m-0">
      <form class="form-inline search-full col" action="#" method="get">
        <div class="form-group w-100">
          <div class="Typeahead Typeahead--twitterUsers">
            <div class="u-posRelative">
              <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Cuba .." name="q" title="" autofocus>
              <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
            </div>
            <div class="Typeahead-menu"></div>
          </div>
        </div>
      </form>
      <div class="header-logo-wrapper col-auto p-0">
        <div class="logo-wrapper"><a href="index.html"><img class="img-fluid" src="{{ asset('frontend/assets/images/logo/logo.png') }}" alt=""></a></div>
        <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
      </div>

      <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
        <ul class="nav-menus">

          <li>
            <div class="mode">
              <svg>
                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#moon') }}"></use>
              </svg>
            </div>
          </li>

          <li class="profile-nav onhover-dropdown pe-0 py-0">
            <div class="media profile-media"><img class="b-r-10" src="{{ asset('frontend/assets/images/dashboard/profile.png') }}" alt="">
                <div class="media-body">
                    @if(Auth::check())
                        <span>{{ Auth::user()->name }}</span>
                        <p class="mb-0 font-roboto">
                            Admin
                            <i class="middle fa fa-angle-down"></i>
                        </p>
                    @else
                        <span>Guest</span>
                    @endif
                </div>
            </div>
            <ul class="profile-dropdown onhover-show-div">
              <li><a href="#"><i data-feather="user"></i><span>Account </span></a></li>
              <li><a href="#"><i data-feather="mail"></i><span>Inbox</span></a></li>
              <li><a href="#"><i data-feather="file-text"></i><span>Taskboard</span></a></li>
              <li><a href="#"><i data-feather="settings"></i><span>Settings</span></a></li>
              <li>
                <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: inherit; padding: 0; cursor: pointer;">
                        <i data-feather="log-in"></i>
                        <span>Log out</span>
                    </button>
                </form>
            </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- Page Header Ends -->