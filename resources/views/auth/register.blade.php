<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->


<head>
    <meta charset="utf-8" />
    <title>{{trans('main.site_title')}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="#1 selling multi-purpose bootstrap admin theme sold in themeforest marketplace packed with angularjs, material design, rtl support with over thausands of templates and ui elements and plugins to power any type of web applications including saas and admin dashboards. Preview page of Theme #1 for "
          name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{url('')}}/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{url('')}}/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{url('')}}/assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> </head>
<style>
    .help-block{
        color:red !important;
    }
</style>
<!-- END HEAD -->

<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">
    <h2 style="font-family: Serif;color: aliceblue;">{{trans('main.site_title')}}</h3>
</div>
<!-- END LOGO -->


<!-- BEGIN LOGIN -->
<div class="content">

    <form class="register-form" action="{{ url('/register') }}" method="post" style="display: block;">
        {{ csrf_field() }}
        <h3 class="font-green">{{trans('auth.sign_up')}}</h3>
        <p class="hint"> {{trans('auth.enter_personal_details')}} </p>
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9">{{trans('auth.name')}}</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="{{trans('auth.name')}}" name="name" value="{{old('name')}}" />
        </div>
                @if ($errors->has('name'))
                    <span class="help-block">{{ $errors->first('name') }}</span>
                @endif
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">{{trans('auth.email')}}</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="{{trans('auth.email')}}" name="email" value="{{old('email')}}"/> </div>
                @if ($errors->has('email'))
                    <span class="help-block">{{ $errors->first('email') }}</span>
                @endif
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{trans('auth.phone')}}</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="{{trans('auth.phone')}}" name="phone" value="{{old('phone')}}" /> </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{trans('auth.mobile')}}</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="{{trans('auth.mobile')}}" name="mobile" value="{{old('mobile')}}" /> </div>


        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9">{{trans('auth.username')}}</label>
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="{{trans('auth.username')}}" name="username" value="{{old('username')}}"> </div>
        @if ($errors->has('username'))
            <span class="help-block">{{ $errors->first('username') }}</span>
        @endif
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9">{{trans('auth.password')}}</label>
            <input class="form-control placeholder-no-fix" type="{{trans('auth.password')}}" autocomplete="off" id="register_password" placeholder="{{trans('auth.password')}}" name="password" /> </div>
        @if ($errors->has('password'))
            <span class="help-block">{{ $errors->first('password') }}</span>
        @endif
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{trans('auth.re_password')}}</label>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{trans('auth.re_password')}}" name="rpassword" /> </div>

        <div class="form-actions">
            <a href="{{url('login')}}" class="btn green btn-outline">{{trans('auth.back')}}</a>
            <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">{{trans('auth.submit')}}</button>
        </div>
    </form>
</div>

<!-- END LOGIN -->
<!--[if lt IE 9]>
<script src="{{url('')}}/assets/global/plugins/respond.min.js"></script>
<script src="{{url('')}}/assets/global/plugins/excanvas.min.js"></script>
<script src="{{url('')}}/assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{url('')}}/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{url('')}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{url('')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{url('')}}/assets/pages/scripts/login.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>
