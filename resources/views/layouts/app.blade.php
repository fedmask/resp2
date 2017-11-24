<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('includes.template_head')
</head>
<body>
@include('includes.template_header')
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    @include('includes.template_footer')
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-2.0.3.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
    <script src="{{ asset('plugins/validationengine/js/jquery.validationEngine.js') }}"></script>
    <script src="{{ asset('plugins/validationengine/js/languages/jquery.validationEngine-it.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation-1.11.1/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation-1.11.1/localization/messages_it.js') }}"></script>
    <script src="{{ asset('plugins/balloon/jquery.balloon.min.js') }}"></script>
    <script src="{{ asset('js/validationInit.js') }}"></script>
    <script src="{{ asset('js/formscripts/sendpatmail.js') }}"></script>
    <script src="{{ asset('js/formscripts/modRemindPw.js') }}"></script>
    <script src="{{ asset('js/formscripts/modpatinfo.js') }}"></script>
    <script src="{{ asset('js/formscripts/modpatpsw.js') }}"></script>
    <script src="{{ asset('js/formscripts/modpatgrsang.js') }}"></script>
    <script src="{{ asset('js/formscripts/modpatdonorg.js') }}"></script>
    <script src="{{ asset('js/formscripts/modpatcontemerg.js') }}"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script src="{{ asset('plugins/autosize/jquery.autosize.min.js') }}"></script>
    <script src="{{ asset('js/formscripts/modanamnesifis.js') }}"></script>
    <script src="{{ asset('js/formscripts/modsicurezza.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('js/formscripts/modanamnesipat.js') }}"></script>
    <script src="{{ asset('js/formscripts/modvaccinazioni.js') }}"></script>
    <script src="{{ asset('js/formscripts/modallergie.js') }}"></script>
    <script src="{{ asset('plugins/autocomplete/typeahead.bundle.js') }}"></script>    
    <!-- TODO: dal footer del vecchio RESP imporatare gli script in base alla pagina caricata -->
</body>
</html>
