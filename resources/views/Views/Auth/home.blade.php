<html>
<head>
    <title>Login Page</title>


    <link type="text/css" rel="stylesheet" href="{{asset('styles/font-awesome.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('styles/login.css')}}"/>
</head>
<body ng-app="OpenTestFrameWork">

<div class="wrapper">
    <div class="AuthArea">
        <div class="Header">
            <div class="Logo">
                <img src="{{asset('images/Logo.png')}}" title="Logo" alt="Logo"/>
            </div>
            <div class="Switch">
                <ul class="switchUl">
                    <a href="#/login"><li class="active">Login</li></a>
                    <a href="#/register"><li class="">Register</li></a>
                </ul>
            </div>
        </div>
        <div class="clear"></div>

        <div ng-view></div>
    </div>

</div>

<!-- Angular Modules And Libs-->
<script type="text/javascript" src="{{asset('app/lib/angular/angular.js')}}"></script>
<script type="text/javascript" src="{{asset('app/lib/angular/angular-route.js')}}"></script>
<script type="text/javascript" src="{{asset('app/lib/angular/ngStorage.js')}}"></script>

<script type="text/javascript" src="{{asset('scripts/jquery-2.2.0.js')}}"></script>

<!-- My App -->
<script type="text/javascript" src="{{asset('app/app.js')}}"></script>
<script type="text/javascript" src="{{asset('app/Services/auth.js')}}"></script>

<script type="text/javascript" src="{{asset('scripts/script.js')}}"></script>


</body>
</html>