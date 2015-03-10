<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <style>
        @import url('/bower_components/bootswatch-dist/css/bootstrap.min.css');
        @import url('/bower_components/selectize/dist/css/selectize.bootstrap3.css');
        @import url('/bower_components/nprogress/nprogress.css');
        body {
            padding-top: 50px;
        }
        .content {
            padding: 40px 15px;
            text-align: center;
        }

        /* Sticky footer styles
-------------------------------------------------- */
        html {
            position: relative;
            min-height: 100%;
        }
        body {
            /* Margin bottom by footer height */
            margin-bottom: 80px;
        }

        dd {
            padding-left: .5em;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 80px;
            background-color: #f5f5f5;
        }

        .container .text-muted {
            margin: 10px 0;
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
    @yield('js-include')
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
                <a class="navbar-brand" href="{{URL::route('home')}}">Foody</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="{{Str::startsWith(Route::currentRouteName(), ['ingredient-']) ? 'active' : ''}}"><a href="{{URL::route('ingredient-detail')}}">Ingredient Search</a></li>
                    <li class="{{Route::currentRouteName() == 'recipe' ? 'active' : ''}}"><a href="{{URL::route('recipe')}}">Recipe Estimator</a></li>
                    {{--<li><a href="#contact">Contact</a></li>--}}
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div><!-- /.container -->
    <footer class="footer">
        <div class="container">
            <p class="text-muted">
                <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">
                    <img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/80x15.png" />
                </a><br />
                Foody by Brian Bolton is licensed under a
                <a rel="license" href="//creativecommons.org/licenses/by-nc-sa/4.0/">
                    Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License
                </a>.<br />
                Nutritional data from USDA National Nutrient Database for Standard Reference licensed under
                <a href="//creativecommons.org/licenses/by/3.0/us/">Creative Commons Attribution 3.0</a>
            </p>
        </div>
    </footer>
</body>
</html>
