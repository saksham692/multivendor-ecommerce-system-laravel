<!DOCTYPE html>
<html lang="en">
<head>
    @include('backend.admin.layouts.includes.head')
</head>

<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
    @include('backend.admin.layouts.includes.header')
    @include('backend.admin.layouts.includes.sidebar')

    <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header shadow">
                    <h1>@yield('title')</h1>
                    <div class="section-header-breadcrumb">
                        @yield('breadcrumb')
                    </div>
                </div>
                @yield('content')
            </section>
        </div>
        @include('backend.admin.layouts.includes.footer')
    </div>
</div>

@yield('modal')

@include('backend.admin.layouts.includes.scripts')
</body>
</html>
