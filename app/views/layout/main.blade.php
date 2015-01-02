<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{ $title }}</title>
    {{ @twitter_bootstrap_css }}

    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <style>
        @import url('/bower_components/selectize/dist/css/selectize.bootstrap3.css');
        @import url('/bower_components/nprogress/nprogress.css');
        body {
            padding-top: 50px;
        }
        .content {
            padding: 40px 15px;
            text-align: center;
        }

        /* Firefox fix for responsive tables */
        @-moz-document url-prefix() {
            fieldset { display: table-cell; }
        }
    </style>

    {{ @jquery_js_tag }}
    {{ @twitter_bootstrap_js }}
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="/bower_components/selectize/dist/js/standalone/selectize.js"></script>
    <script src="/bower_components/nprogress/nprogress.js"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Recipe Manager</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    {{--<li><a href="#about">About</a></li>--}}
                    {{--<li><a href="#contact">Contact</a></li>--}}
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div><!-- /.container -->
</body>
</html>
