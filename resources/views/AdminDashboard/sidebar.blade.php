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
                        <a class="sidebar-link sidebar-title" href="{{ route('indexxx') }}">
                            <i class="fa fa-shield"></i>
                            <span>Customers Request</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('indexxx') }}">Vehicle Insurance</a></li>
                            {{-- <li><a href="{{ route('health.index') }}">Health Insurance</a></li>
                            <li><a href="{{ route('indexxx') }}">Life Insurance</a></li> --}}
                        </ul>
                    </li>

                    {{-- forms --}}

                    <li class="sidebar-main-title">
                        <div><h6>Forms</h6></div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i class="fa fa-shield"></i>
                            <span>Master</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customerResponses.index') }}">Customer Response</a></li>
                            <li><a href="{{ route('insuranceType.index') }}">Insurance Types</a></li>
                            <li><a href="{{ route('categories.index') }}">Categories</a></li>
                            <li><a href="{{ route('subcategories.index') }}">Sub Categories</a></li>
                            <li><a href="{{ route('formField.index') }}">Form Field</a></li>
                        </ul>
                    </li>

                    {{-- master --}}
{{--
                    <li class="sidebar-main-title">
                        <div><h6>Master</h6></div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i class="fa fa-shield"></i>
                            <span>Insurance Types</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ route('indexxx') }}">Life Insurance</a>
                            </li>
                            <li>
                                <a class="sidebar-link sidebar-title" href="#">General Insurance</a>
                                <ul class="sidebar-submenu">
                                    <li>
                                        <a class="sidebar-link sidebar-title" href="#">Motor Insurance</a>
                                        <ul class="sidebar-submenu">
                                            <li><a href="{{ route('private.car') }}">Private Car</a></li>
                                            <li><a href="{{ route('indexxx') }}">Private Van</a></li>
                                            <li><a href="{{ route('indexxx') }}">Motorcycle</a></li>
                                            <li><a href="{{ route('indexxx') }}">Private Lorry</a></li>
                                            <li><a href="{{ route('indexxx') }}">Private Business</a></li>
                                            <li><a href="{{ route('indexxx') }}">Private - Special Purpose Vehicle</a></li>
                                            <li><a href="{{ route('indexxx') }}">Hiring Car</a></li>
                                            <li><a href="{{ route('indexxx') }}">Hiring Van</a></li>
                                            <li><a href="{{ route('indexxx') }}">Hiring Motorcycle</a></li>
                                            <li><a href="{{ route('indexxx') }}">Hiring Lorry</a></li>
                                            <li><a href="{{ route('indexxx') }}">Hiring Business</a></li>
                                            <li><a href="{{ route('indexxx') }}">Hiring - Special Purpose Vehicle</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('indexxx') }}">Non Motor Insurance</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> --}}



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

                    <!-- Insurance Management -->
                    <li class="sidebar-main-title">
                        <div><h6>Insurance Customers</h6></div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="">
                            <i class="fa fa-shield"></i>
                            <span>Manage Customers</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('new-customer') }}">View All Customers</a></li>
                            <li><a href="{{ route('viewRequest') }}">View Customer Request</a></li>
                            {{-- <li><a href="{{ route('indexxx') }}">Life Insurance</a></li> --}}
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
    var sidebarTitles = document.querySelectorAll(".sidebar-title");

    sidebarTitles.forEach(function (title) {
        title.addEventListener("click", function (e) {
            e.preventDefault(); // Prevent default action

            let submenu = this.nextElementSibling; // Get the submenu
            if (submenu && submenu.classList.contains("sidebar-submenu")) {
                submenu.classList.toggle("d-block"); // Toggle visibility
            }
        });
    });
});

</script>
