@include('includes/header')

<body>
    <div class="app sidebar-mini">


    <!-- PAGE -->
    <div class="page">
        <div class="page-main">

        <!--APP-SIDEBAR-->
        <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>

        @include('includes/sidebar')

        @include('includes/top_bar')

        <main class="py-4">
            <div class="app-content">
                <div class="side-app">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>


    @include('includes/footer')

    @yield('scripting')

</body>
</html>
