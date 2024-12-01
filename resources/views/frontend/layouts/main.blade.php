<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.layouts.includes.head')
</head>
<body class="animsition">

<!-- Header -->
    <header>
        @include('frontend.layouts.includes.header')
    </header>

    @include('frontend.layouts.includes.cart')

    @yield('content')

    @include('frontend.layouts.includes.footer')

    @yield('modal')

@include('frontend.layouts.includes.scripts')
</body>
</html>
