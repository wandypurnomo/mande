<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset("img/apple-icon.png") }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset("img/favicon.png") }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>@yield("title","Administrator")</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{{ asset("css/animate.min.css") }}" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="{{ asset("css/paper-dashboard.css") }}" rel="stylesheet"/>

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset("css/themify-icons.css") }}" rel="stylesheet">
    @stack("styles")
    <style>
        .login-container{
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body style="background-color: #ddd;">
<div class="wrapper">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="login-container">
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Login</h3>
                            </div>
                            <div class="panel-body">
                                {!! Form::open() !!}
                                    <div class="form-group has-feedback">
                                        <span class="form-control-feedback" style="color: black"><i class="fa fa-user"></i></span>
                                        {!! Form::email("email",null,["id"=>"email","class"=>"form-control border-input","placeholder"=>"Input your email here","required"]) !!}
                                    </div>

                                    <div class="form-group has-feedback">
                                        <span class="form-control-feedback" style="color: black"><i class="fa fa-lock"></i></span>
                                        {!! Form::password("password",["id"=>"password","class"=>"form-control border-input","placeholder"=>"Input your password here","required"]) !!}
                                    </div>

                                    <div class="form-group">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-warning">Login</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stack("models")
</body>

<!--   Core JS Files   -->
<script src="{{ asset("js/jquery-1.10.2.js") }}" type="text/javascript"></script>
<script src="{{ asset("js/bootstrap.min.js") }}" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="{{ asset("js/bootstrap-checkbox-radio.js") }}"></script>

<!--  Charts Plugin -->
<script src="{{ asset("js/chartist.min.js") }}"></script>

<!--  Notifications Plugin    -->
<script src="{{ asset("js/bootstrap-notify.js") }}"></script>

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
{{--<script src="{{ asset("js/paper-dashboard.js") }}"></script>--}}
@stack("scripts")

</html>
