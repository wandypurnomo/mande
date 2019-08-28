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
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link href="{{ asset("css/themify-icons.css") }}" rel="stylesheet">
    @routes
    @stack("styles")

</head>
<body>
<div class="wrapper">
    @include("partials.sidebar")

    <div class="main-panel">
        @component("partials.nav")
            @yield("nav_title","Template")
        @endcomponent

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @yield("contents")
                </div>
            </div>
        </div>

        @include("partials.footer")
    </div>
</div>
@stack("modals")

<!--   Core JS Files   -->
{{--<script src="{{ asset("js/jquery.min.js") }}" type="text/javascript"></script>--}}
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="{{ asset("js/bootstrap.min.js") }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>


<!--  Checkbox, Radio & Switch Plugins -->
<script src="{{ asset("js/bootstrap-checkbox-radio.js") }}"></script>

<!--  Charts Plugin -->
<script src="{{ asset("js/chartist.min.js") }}"></script>

<!--  Notifications Plugin    -->
<script src="{{ asset("js/bootstrap-notify.js") }}"></script>

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script src="{{ asset("js/paper-dashboard.js") }}"></script><!-- DataTables -->
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script>
    @if(session()->has("success"))
    $.notify("{{ session('success') }}",{
        timer:1000,
        type:"success"
    });
    @endif

    @if(session()->has("error"))
    $.notify("{{ session('error') }}",{
        timer:1000,
        type:"warning"
    });
    @endif

    @if(session()->has("empty_statement") && session("empty_statement"))
    $.notify("Failed to load statement data.",{
        timer:1000,
        type:"danger"
    });
    @endif

    @if(count($errors->all()) > 0)
    @foreach($errors->all() as $error)
    $.notify("{{ $error }}",{
        timer:1000,
        type:"danger"
    });
    @endforeach
    @endif
</script>
@stack("scripts")
</body>

</html>
