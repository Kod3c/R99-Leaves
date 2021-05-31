<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir = "{{env('SITE_RTL') == 'on'?'rtl':''}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="description" content="RotaGo - Staff Scheduling Tool">
    <meta name="author" content="Rajodiya Infotech">

    <!-- CSRF Token -->    
    @php
        $logo = asset(Storage::url('uploads/logo/'));
        $favicon=\Utility::getValByName('favicon');
    @endphp    
    
    <meta name="csrf-token" content="{{ csrf_token() }}">    
    <title>@yield('page-title') - {{(Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'RotaGo')}}</title>        
    <link rel="icon" href="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" type="image" sizes="16x16">        
    <script src="{{ asset('js/app.js') }}" defer></script>    
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">       
    <link rel="stylesheet" href="{{ asset('assets/libs/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/site.css')}}" id="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css')}}">

    @if(env('SITE_RTL')=='on')
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-rtl.css') }}">
    @endif

</head>
<body class="application application-offset sidenav-pinned ready">
<div id="app">
    <main class="py-4">
        @yield('content')
    </main>
</div>
<!-- Scripts -->
<!-- Core JS - includes jquery, bootstrap, popper, in-view and sticky-kit -->
<script src="{{ asset('assets/js/site.core.js')}}"></script>
<script src="{{ asset('assets/libs/progressbar.js/dist/progressbar.min.js')}}"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{ asset('assets/libs/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/libs/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.js')}}"></script>
<script src="{{ asset('assets/js/site.js')}}"></script>
<script src="{{ asset('assets/js/custom.js')}}"></script>
<!-- Demo JS - remove it when starting your project -->
<script src="{{ asset('assets/js/demo.js')}}"></script>

<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js')}}"></script>
@stack('pagescript')

@if (\Session::has('success'))
<script>
    show_toastr('{{__('Success')}}', '{!! session('success') !!}', 'success');
</script>
{{ Session::forget('success') }}
@endif

@if (Session::has('error'))
<script>
    show_toastr('{{__('Error')}}', '{!! session('error') !!}', 'error');
</script>
{{ Session::forget('error') }}
@endif
</body>
</html>
