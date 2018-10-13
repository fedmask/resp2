<meta charset="utf-8"/>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>RESP - @yield('pageTitle', 'Home')</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
<!-- STILI GLOBALI -->
<link rel="stylesheet" href="/plugins/bootstrap/css/bootstrap.css"/>
<link rel="stylesheet" href="/css/main.css"/>
<link rel="stylesheet" href="/css/theme.css"/>
<link rel="stylesheet" href="/css/MoneAdmin.css"/>
<link rel="stylesheet" href="/plugins/Font-Awesome/css/font-awesome.css"/>
<!--FINE STILI GLOBALI -->

<!-- PAGE LEVEL STYLES -->
<link href="/css/layout2.css" rel="stylesheet"/>
<!-- END PAGE LEVEL  STYLES -->
<!--STILI FORM AVANZATO-->
<link rel="stylesheet" href="/plugins/validationengine/css/validationEngine.jquery.css"/>
<link href="/css/jquery-ui.css" rel="stylesheet"/>
<link rel="stylesheet" href="/plugins/uniform/themes/default/css/uniform.default.css"/>
<link rel="stylesheet" href="/plugins/inputlimiter/jquery.inputlimiter.1.0.css"/>
<link rel="stylesheet" href="/plugins/chosen/chosen.min.css"/>
<link rel="stylesheet" href="/plugins/colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" href="/plugins/tagsinput/jquery.tagsinput.css"/>
<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" href="/plugins/datepicker/css/datepicker.css"/>
<link rel="stylesheet" href="/plugins/timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" href="/plugins/switch/static/stylesheets/bootstrap-switch.css"/>
<!-- FINE STILI FORM AVANZATO-->
<!--STILI TABELLE DINAMICHE-->
<link href="/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet"/>
<!--FINE STILI TABELLE DINAMICHE-->
<!-- STILI FILE UPLOAD -->
<link rel="stylesheet" href="/css/bootstrap-fileupload.min.css"/>
<link rel="stylesheet" href="/plugins/fileinput/css/fileinput.css"/>
<!-- FINE STILI FILE UPLOAD -->
<!--STILE AUTOCOMPLETE-->
<link rel="stylesheet" href="/plugins/jQuery-Autocomplete-master/src/bootstrap.css"/>
<!--STILE AUTOCOMPLETE-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

 <style>
/* The container */
.container {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}
</style>   