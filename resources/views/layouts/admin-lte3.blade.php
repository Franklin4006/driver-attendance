@include('layouts.header')
@include('layouts.sidebar')

<main class="py-4">
    @yield('content')
</main>

@include('layouts.footer')
@yield('addscript')

