<!-- Page Sidebar Start -->
<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('dashboard') }}">
                <img class="img-fluid for-light" src="{{ asset('frontend/assets/images/logo/logo-img.jpg') }}" style="width: 100px; height:50px; margin-left:30px;" alt="logo">
                <img class="img-fluid for-dark"  src="{{ asset('frontend/assets/images/logo/logo-img.jpg') }}" style="width: 100px; height:50px; margin-left:30px;" alt="logo-dark">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"></i></div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="{{ route('dashboard') }}"><img class="img-fluid" src="frontend/assets/images/logo/logo-icon.png" alt=""></a>
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
                        <a class="sidebar-link" href="{{ route('dashboard') }}">
                            <i class="fa fa-home"></i> <!-- Corrected Icon -->
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Customer Management -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('indexxx') }}">
                            <i class="fa fa-users"></i> <!-- Corrected Icon -->
                            <span>Customers Management</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('new-customer') }}">All Customers</a></li>
                            <li><a href="{{ route('create-customer') }}">Add Customers</a></li>
                            <li><a href="{{ route('customerinsurance.index') }}">Customer Insurance</a></li>
                        </ul>
                    </li>

                    <!-- Insurance Companies -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i class="fa fa-building"></i> <!-- Corrected Icon -->
                            <span>Insurance Companies</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('company.index') }}">View All Companies</a></li>
                            <li><a href="{{ route('company.create') }}">Add New Company</a></li>
                        </ul>
                    </li>

                    <!-- Insurance Requests -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                        <i class="fa fa-file-text"></i> <!-- Corrected Icon -->
                            <span>Insurance Requests</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customerResponse.create') }}">Create Customer Request</a></li>
                            <li><a href="{{ route('indexxx') }}">Notsend Request</a></li>
                            <li><a href="{{ route('sendindex') }}">send Request</a></li>
                        </ul>
                    </li>

                    <!-- Master Files -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i class="fa fa-folder"></i> <!-- Corrected Icon -->
                            <span>Master Files</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('insuranceType.index') }}">Insurance Types</a></li>
                            <li><a href="{{ route('categories.index') }}">Categories</a></li>
                            <li><a href="{{ route('subcategories.index') }}">Sub Categories</a></li>
                            <li><a href="{{ route('formField.index') }}">Variety Fields</a></li>
                        </ul>
                    </li>


                    <!-- Agents Section -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i class="fa fa-user"></i> <!-- Agent Icon -->
                            <span>Agents</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('agents.index') }}">All Agents</a></li>
                            <li><a href="{{ route('sub_agents.index') }}">Sub Agents</a></li>
                        </ul>
                    </li>

                    <!-- Profit Magin Section -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i class="fa fa-money"></i> <!-- Profit Icon -->
                            <span>Profit Margins</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('profitMargin.create')  }}">Add Profit Margin</a></li>
                            <li><a href="{{ route('profitMargin.index') }}">All Profit Margin</a></li>
                        </ul>
                    </li>

                    <!-- Commission Section -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i class="fa fa-credit-card-alt"></i> <!-- commission Icon -->
                            <span>Commissions</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('commissions.rib') }}">RIB Commissions</a></li>
                            <li><a href="{{ route('commissions.agent') }}">Agent Commissions</a></li>
                            <li><a href="{{ route('commissions.subagent') }}">Sub Agent Commissions</a></li>
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
