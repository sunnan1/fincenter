<!DOCTYPE html>
<html lang="en">
<head>
    <title>FinCenter</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/util.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/main.css">
    <!--===============================================================================================-->
    <meta name="robots" content="noindex, follow">
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="{{ url('/') }}/img-01.webp" alt="IMG">
            </div>
            <form class="login100-form validate-form">
					<span class="login100-form-title">
						Member Login
					</span>
                <div class="container-login100-form-btn">
                    <a href="{{ url('/auth/google') }}" class="login100-form-btn">
                        Google Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
