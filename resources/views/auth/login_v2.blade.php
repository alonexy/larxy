<!DOCTYPE HTML>
<html>
<head>
    <title>Home</title>
    <!-- Custom Theme files -->
    <link href="/static/admin_login/css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Custom Theme files -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Login form web template, Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
    <!--Google Fonts-->
    <link href='/static/admin_login/css/a.css' rel='stylesheet' type='text/css'>
    <link href='/static/admin_login/css/b.css' rel='stylesheet' type='text/css'>
    <!--Google Fonts-->
</head>
<body>
<div class="login">
    <h2>AlonexyAdmin</h2>
    <div class="login-top">
        <h1>LOGIN</h1>
        @if (count($errors) > 0)
            <div class="alert alert-error" style="text-align: center">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="/auth/login">
            {!! csrf_field() !!}
            <input type="email" name="email" value="{{ old('email') }}" value="User Id" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'User Id';}">
            <input type="password" value="password" name="password" id="password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'password';}">
            <br />
            <input type="checkbox" name="remember"> 记住我
        <div class="forgot">
            <input type="submit" value="Login" >
        </div>
        </form>
    </div>

</div>
</body>
</html>