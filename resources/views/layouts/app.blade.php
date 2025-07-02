<!DOCTYPE html>
<html lang="zxx">

    @include('partials.head')
    @livewireStyles
<body>
		<!-- Left sidebar -->

    @include('layouts.left-sidebar')
	<!-- Header Section Start -->
    @include('layouts.header')
    <!--! ================================================================ !-->
    <!--! [Start] Main Content !-->
    <!--! ================================================================ !-->
    @yield('content')
    <!--! ================================================================ !-->
    <!--! ================================================================ !-->
	@include('layouts.footer')
    <!--<< Footer Section Start >>-->
	<!--<< All JS Plugins >>-->
    @include('partials.script')
    @include('partials.homepage-script')

    @stack('js')
    @livewireScripts
</body>

</html>