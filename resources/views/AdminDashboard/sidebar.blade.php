<!-- Page Sidebar Start -->
<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="index.html">
                <img class="img-fluid for-light" src="frontend/assets/images/logo/logo.png" alt="">
                <img class="img-fluid for-dark" src="frontend/assets/images/logo/logo_dark.png" alt="">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"></i></div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="index.html"><img class="img-fluid" src="frontend/assets/images/logo/logo-icon.png" alt=""></a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="{{ route('dashboard') }}">
                            <img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="">
                        </a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    
                    <!-- Dashboard -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('dashboard') }}">
                            <i class="fa fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <!-- Insurance Management -->
                    <li class="sidebar-main-title">
                        <div><h6>Insurance Requests</h6></div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i class="fa fa-shield"></i>
                            <span>Insurance Types</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('indexxx') }}">Vehicle Insurance</a></li>
                            <li><a href="{{ route('indexxx') }}">Health Insurance</a></li>
                            <li><a href="{{ route('indexxx') }}">Life Insurance</a></li>
                        </ul>
                    </li>
                    
                    <!-- Insurance Companies -->
                    <li class="sidebar-main-title">
                        <div><h6>Insurance Companies</h6></div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i class="fa fa-building"></i>
                            <span>Manage Companies</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('company.index') }}">View All Companies</a></li>
                            <li><a href="{{ route('company.create') }}">Add New Company</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends -->
