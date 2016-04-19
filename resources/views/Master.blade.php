<!DOCTYPE>
<html>
<head >
    <title> Open Test FrameWork </title>
    <link type="text/css" rel="stylesheet" href="{{asset('styles/bootstrap.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('styles/bootstrap-theme.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('styles/bootstrap.css')}}"/>
</head>

<body ng-app="OpenTestFrameWork">

    <div id="main">
        <div ng-view></div>

    </div>

<!-- Angular Modules And Libs-->
<script type="text/javascript" src="{{asset('app/lib/angular/angular.js')}}"></script>
<script type="text/javascript" src="{{asset('app/lib/angular/angular-animate.js')}}"></script>
<script type="text/javascript" src="{{asset('app/lib/angular/angular-route.js')}}"></script>

<!-- My App -->
<script type="text/javascript" src="{{asset('app/app.js')}}"></script>

</body>
</html>