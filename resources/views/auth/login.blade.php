<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <meta name="description" content="Custom Login Form Styling with CSS3" />
    <meta name="keywords" content="css3, login, form, custom, input, submit, button, html5, placeholder" />
    <meta name="author" content="Codrops" />
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/static/2/css/style.css" />
    <script src="/static/2/modernizr.custom.63321.js"></script>
    <!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
    <style>
        body {
            background: #e1c192 url(/static/2/images/wood_pattern.jpg);
        }
    </style>
</head>
<body>

<div class="container">
    @if (count($errors) > 0)
        <div style="background-color: #5bc779">
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="text-align: center">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="main">
        <form class="form-2" method="POST" action="/auth/login">
            {!! csrf_field() !!}
            <h1><span class="log-in">Log in</span></h1>
            <p class="float">
                <label for="login"><i class="icon-user"></i>USER</label>
                <input type="text" name="email" placeholder="Username or email" value="{{old('email')}}">
            </p>
            <p class="float">
                <label for="password"><i class="icon-lock"></i>Password</label>
                <input type="password" name="password" placeholder="Password" class="showpassword">
            </p>
            <p class="clearfix">
                <a href="#" class="log-twitter">Log in with Wechat</a>
                <input type="submit" name="submit" value="Log in">
            </p>
        </form>​​
    </section>

</div>
<!-- jQuery if needed -->
<script type="text/javascript" src="/static/jquery1_8.js"></script>
<script src="/layer/layer.js"></script>
<script type="text/javascript">
    $(function(){
        $(".showpassword").each(function(index,input) {
            var $input = $(input);
            $("<p class='opt'/>").append(
                    $("<input type='checkbox' class='showpasswordcheckbox' id='showPassword' />").click(function() {
                        var change = $(this).is(":checked") ? "text" : "password";
                        var rep = $("<input placeholder='Password' type='" + change + "' />")
                                .attr("id", $input.attr("id"))
                                .attr("name", $input.attr("name"))
                                .attr('class', $input.attr('class'))
                                .val($input.val())
                                .insertBefore($input);
                        $input.remove();
                        $input = rep;
                    })
            ).append($("<label for='showPassword'/>").text("Show password")).insertAfter($input.parent());
        });

        $('#showPassword').click(function(){
            if($("#showPassword").is(":checked")) {
                $('.icon-lock').addClass('icon-unlock');
                $('.icon-unlock').removeClass('icon-lock');
            } else {
                $('.icon-unlock').addClass('icon-lock');
                $('.icon-lock').removeClass('icon-unlock');
            }
        });
        $(".log-twitter").bind({
            click:function(){
                layer.msg('Coding');
            }
        })
    });
</script>
</body>
</html>