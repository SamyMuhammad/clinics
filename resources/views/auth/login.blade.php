<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>{{ $title }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
        type="text/css" />
    <link href="{{ custom_asset('metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ custom_asset('metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap/css/bootstrap-rtl.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch-rtl.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ custom_asset('metronic/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ custom_asset('metronic/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ custom_asset('metronic/assets/global/css/components-rounded-rtl.min.css') }}" rel="stylesheet"
        id="style_components" type="text/css" />
    <link href="{{ custom_asset('metronic/assets/global/css/plugins-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{ custom_asset('metronic/assets/pages/css/login-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link href="{{ custom_asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->

<body class=" login">
    @if (!request()->routeIs('admin.*'))
        @if (app()->getLocale() === 'ar')
        <a class="lang-link login-link" href="{{ route('switchLang', 'en') }}">English</a>
        @else
        <a class="lang-link login-link" href="{{ route('switchLang', 'ar') }}">العربية</a>
        @endif
    @endif
    <!-- LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content" style="margin-top: 150px;">
        <!-- BEGIN LOGIN FORM -->
        <form class="login-form" action="{{ route($loginRoute) }}" method="post">
            @csrf
            <h3 class="form-title font-green">{{ __('login.heading') }}</h3>
            @if ($errors->any())
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="form-group">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">{{ __('login.email') }}</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="text"
                    placeholder="{{ __('login.email') }}" name="email" />
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">{{ __('login.heading') }}</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password"
                    placeholder="{{ __('login.password') }}" name="password" />
            </div>
            <div class="form-actions">
                <button type="submit" class="btn green uppercase">{{ __('login.submit') }}</button>
                <label class="rememberme check mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" name="remember" value="1" />{{ __('login.rememberMe') }}
                    <span></span>
                </label>
                {{-- <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a> --}}
            </div>
        </form>
        <!-- END LOGIN FORM -->
        <!-- BEGIN FORGOT PASSWORD FORM -->
        {{-- <form class="forget-form" action="index.html" method="post">
            <h3 class="font-green">Forget Password ?</h3>
            <p> Enter your e-mail address below to reset your password. </p>
            <div class="form-group">
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email"
                    name="email" /> </div>
            <div class="form-actions">
                <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
                <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
            </div>
        </form> --}}
        <!-- END FORGOT PASSWORD FORM -->
        <!-- REGISTRATION FORM -->
    </div>
    {{-- <div class="copyright"> 2014 © Metronic. Admin Dashboard Template. </div> --}}
    <!--[if lt IE 9]>
    <script src="{{ custom_asset('metronic/assets/global/plugins/respond.min.js') }}"></script>
    <script src="{{ custom_asset('metronic/assets/global/plugins/excanvas.min.js') }}"></script> 
    <script src="{{ custom_asset('metronic/assets/global/plugins/ie8.fix.min.js') }}"></script> 
    <![endif]-->
    <!-- BEGIN CORE PLUGINS -->
    <script src="{{ custom_asset('metronic/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ custom_asset('metronic/assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
    <script src="{{ custom_asset('metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ custom_asset('metronic/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
    <script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"
        type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ custom_asset('metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ custom_asset('metronic/assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ custom_asset('metronic/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript">
    </script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{ custom_asset('metronic/assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ custom_asset('metronic/assets/pages/scripts/login.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <!-- END THEME LAYOUT SCRIPTS -->
    <script>
        $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
    </script>
</body>

</html>