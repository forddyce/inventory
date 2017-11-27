<header id="page-header">
  <div class="content-header">
    <div class="content-header-section">
      <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
        <i class="fa fa-navicon"></i>
      </button>
{{--       <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="header_search_on">
        <i class="fa fa-search"></i>
      </button> --}}
    </div>
    <div class="content-header-section">
      <div class="btn-group" role="group">
        <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ $user->email }} <i class="fa fa-angle-down ml-5"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right min-width-150" aria-labelledby="page-header-user-dropdown">
          <a class="dropdown-item" href="{{ route('settings') }}">
            <i class="si si-wrench mr-5"></i> Settings
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}">
            <i class="si si-logout mr-5"></i> Logout
          </a>
        </div>
      </div>
{{--       <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="side_overlay_toggle">
        <i class="fa fa-tasks"></i>
      </button> --}}
    </div>
  </div>
  <div id="page-header-search" class="overlay-header">
    <div class="content-header content-header-fullrow">
      <form action="be_pages_generic_search.php" method="post">
        <div class="input-group">
          <span class="input-group-btn">
            <button type="button" class="btn btn-secondary" data-toggle="layout" data-action="header_search_off">
              <i class="fa fa-times"></i>
            </button>
          </span>
          <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-secondary">
              <i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </form>
    </div>
  </div>
  <div id="page-header-loader" class="overlay-header bg-primary">
    <div class="content-header content-header-fullrow text-center">
      <div class="content-header-item">
        <i class="fa fa-sun-o fa-spin text-white"></i>
      </div>
    </div>
  </div>
</header>
