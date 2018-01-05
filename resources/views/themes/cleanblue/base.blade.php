<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(isset($repository))
            {{ $repository->name }} Documentation
        @else
            {{ env('APP_URL') }}
        @endif
    </title>

    <!-- bootstrap CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    
    <link href="/css/prism.css" rel="stylesheet">
    <link rel="stylesheet" href="/themes/cleanblue/css/styles.min.css">
    <link rel="stylesheet" href="/css/accordion.css">
    
</head>

<body>
<div>
        <nav class="navbar navbar-default navigation-clean" style="background-color:rgb(255,255,255);background-image:url(&quot;/themes/cleanblue/img/header_image.jpg&quot;);">
            <div class="container">
                <div class="navbar-header"><a class="navbar-brand" href="#" style="color:rgb(255,255,255);">
                @if(isset($repository))
                    <span class="fa fa-book"></span> {{ $repository->name }}
                @else
                    {{ env('APP_URL') }}
                @endif
                </a><button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button></div>
                <div
                    class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li role="presentation"><a href="http://{{ env('APP_URL') }}/login" style="color:rgb(255,255,255);">Login </a></li>
                    </ul>
                    <!--
                    <ul class="nav navbar-nav navbar-left">
                        <li role="presentation"><a href="#" style="color:rgb(255,255,255);">Github </a></li>
                    </ul>
                    -->
                </div>
            </div>
        </nav>
    </div>
    <div>
        <div class="container-fluid">
            <div class="row" style="background-color:#f6f7f8;">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div style="height:0;margin-bottom:10px;padding-top:10px;padding-bottom:31px;">
                        <div class="dropdown"><button class="btn btn-default dropdown-toggle text-dropdown" data-toggle="dropdown" aria-expanded="false" type="button">
                            <!-- Current Version -->
                            @if(isset($currentVersion))
                                {{ $currentVersion }}
                            @else
                                {{ $repository->default_version }}
                            @endif
                        <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                
                                @foreach($versions as $version)
                                    <li role="presentation"><a href="/v/{{ $version }}">{{ $version }}</a></li>
                                @endforeach 
                            </ul>
                        </div>
                        <p style="margin-left:20px;color:rgb(92,91,91);"> </p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right" style="padding-top:15px;padding-bottom:15px;">
                    <form action="/search/{{ $currentVersion ?? 'current' }}" method="GET">
                    
                        <span class="hidden-xs"><i class="fa fa-search" style="margin-right:7px;color:#555555;"></i></span>
                        <input type="search" name="q" placeholder="Search" style="background-color:transparent;border:none;margin-right:30px;">
                    
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12" style="height:100vh;overflow:auto;border-right:1px solid #dfe8ee;padding-top:30px;">
                @yield('section_left')
            </div><!-- ./left column -->
        
            <div class="col-md-9 col-sm-9 col-xs-12" style="padding-top:17px;">
                @yield('section_right')
            </div>

        </div><!-- ./row -->
    </div><!-- ./container -->

    <script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="/js/prism.js"></script>
    <script src="/js/accordion.js"></script>

</body>

</html>