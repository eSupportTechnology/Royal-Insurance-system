<!-- Page Sidebar Start -->
<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('rep.dashboard') }}">
                <img class="img-fluid for-light" src="{{ asset('frontend/assets/images/logo/logo-img.jpg') }}"
                    style="width: 100px; height:50px; margin-left:30px;" alt="logo">
                <img class="img-fluid for-dark" src="{{ asset('frontend/assets/images/logo/logo-img.jpg') }}"
                    style="width: 100px; height:50px; margin-left:30px;" alt="logo-dark">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"></i></div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="{{ route('rep.dashboard') }}"><img class="img-fluid"
                    src="frontend/assets/images/logo/logo-icon.png" alt=""></a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="{{ route('rep.dashboard') }}">
                            <img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="">
                        </a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>

                    @php
                        $rep = Auth::guard('rep')->user();
                    @endphp

                    <!-- Commission Section -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i class="fa fa-credit-card-alt"></i>
                            <span>Commissions</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @if ($rep && $rep->role === 'agent')
                                <li><a href="{{ route('rep.commissions.agent') }}">Agent Commissions</a></li>
                            @elseif ($rep && $rep->role === 'subagent')
                                <li><a href="{{ route('rep.commissions.subagent') }}">Sub Agent Commissions</a></li>
                            @endif
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
    document.addEventListener("DOMContentLoaded", function() {
        var sidebarTitles = document.querySelectorAll(".sidebar-title");

        sidebarTitles.forEach(function(title) {
            title.addEventListener("click", function(e) {
                e.preventDefault(); // Prevent default action

                let submenu = this.nextElementSibling; // Get the submenu
                if (submenu && submenu.classList.contains("sidebar-submenu")) {
                    submenu.classList.toggle("d-block"); // Toggle visibility
                }
            });
        });
    });
</script>
