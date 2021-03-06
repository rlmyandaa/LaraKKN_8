<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('template_title')@yield('template_title') | @endif {{ config('app.name', Lang::get('titles.app')) }}</title>
    <meta name="description" content="">
    <link rel="icon" href="{{ url('favicons/favicon.ico?v=1') }}" type="image/x-icon"/>

    {{-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --}}
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    {{-- Fonts --}}
    @yield('template_linked_fonts')

    {{-- Styles --}}

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    @yield('template_linked_css')

    <style type="text/css">
        @yield('template_fastload_css')
    </style>

    {{-- Scripts --}}
    <script>
        window.Laravel = {!!json_encode(['csrfToken' => csrf_token(),]) !!};
    </script>
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
   
    @stack('styles_addon')
    @stack('scripts_addon')


    @yield('head')
</head>

<body>
    <div id="app">

        @include('Modules.partials.nav')

        <main class="py-4">

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @include('partials.form-status')
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 offset-md-1">

                        <div class="card">
                            <div class="card-header">
                                @if (Auth::User()->hasRole('student'))
                                @include('Modules.partials.student-menu')
                                @elseif (Auth::User()->hasRole('dosen'))
                                @include('Modules.partials.dosen-menu')
                                @endif
                            </div>

                            <div class="card-body">
                                @yield('content')
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </main>

    </div>

    {{-- Scripts --}}


    @if(config('settings.googleMapsAPIStatus'))
    {!! HTML::script('//maps.googleapis.com/maps/api/js?key='.config("settings.googleMapsAPIKey").'&libraries=places&dummy=.js', array('type' => 'text/javascript')) !!}
    @endif

    @yield('footer_scripts')

</body>

</html>