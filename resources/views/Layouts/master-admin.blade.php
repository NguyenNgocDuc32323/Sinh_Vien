@include('Layouts.header')
<div class="layout-container">
    @include('layouts.sidebar-admin')
    <div class="overlay"></div>
    <div class="dashboard-main">
        @include('layouts.navbar-admin')
        @include('layouts.main')
    </div>
</div>
@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbarToggle = document.querySelector('.navbar-toggle');
            const sidebar = document.querySelector('.sidebar');
            const dashboardMain = document.querySelector('.dashboard-main');
            const sidebarClose = document.querySelector('.sidebar-close-btn');
            const barMobile = document.querySelector('.bars-mobile');
            const overlay = document.querySelector('.overlay');
            const body = document.body;
            const dropblock = document.querySelector('.dropdown-block');
            function handleResize() {
                const windowWidth = window.innerWidth;

                if (windowWidth >= 992) {
                    if (sidebar.classList.contains('sidebar-open')) {
                        sidebar.classList.remove('sidebar-open');
                        body.classList.remove('overlay-active');
                        if (overlay) overlay.classList.remove('active');
                    }
                    if (sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                    }
                    if (dashboardMain.classList.contains('active')) {
                        dashboardMain.classList.remove('active');
                    }
                    if (navbarToggle && navbarToggle.classList.contains('active')) {
                        navbarToggle.classList.remove('active');
                    }
                    if (overlay) overlay.classList.remove('active');
                } else {
                    if (sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                        dashboardMain.classList.remove('active');
                        if (navbarToggle) navbarToggle.classList.remove('active');
                        if (overlay) overlay.classList.remove('active');
                    }
                }
            }

            if (navbarToggle && sidebar && dashboardMain) {
                navbarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    dashboardMain.classList.toggle('active');
                    navbarToggle.classList.toggle('active');
                    dropblock.classList.toggle('active');
                    if (overlay) overlay.classList.toggle('active');
                });
            }

            if (barMobile) {
                barMobile.addEventListener('click', function() {
                    sidebar.classList.toggle('sidebar-open');
                    body.classList.toggle('overlay-active');
                    dashboardMain.classList.toggle('active');
                    barMobile.classList.toggle('active');
                    if (overlay) {
                        overlay.classList.toggle('active');
                    }
                });
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', function() {
                    sidebar.classList.remove('sidebar-open');
                    body.classList.remove('overlay-active');
                    dashboardMain.classList.remove('active');
                    if (overlay) overlay.classList.remove('active');
                });
            }
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('sidebar-open');
                    dashboardMain.classList.remove('active');
                    overlay.classList.remove('active');
                    body.classList.remove('overlay-active');
                });
            }

            window.addEventListener('resize', handleResize);
            handleResize();
        });
    </script>
@endpush
@include('Layouts.footer_admin')

