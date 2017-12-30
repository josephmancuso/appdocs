<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocsForCode Dashboard</title>

    <!-- bootstrap CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    
</head>

<body>
    <div>
        <nav class="navbar navbar-default navigation-clean" style="background-color:rgb(255,255,255);background-image:url(&quot;/themes/cleanblue/img/header_image.jpg&quot;);margin-bottom:0px;">
            <div class="container">
                <div class="navbar-header"><a class="navbar-brand" href="#" style="color:rgb(255,255,255);"><i class="fa fa-book"></i> DocsForCode </a><button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button></div>
                <div
                    class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav navbar-right">
                        {{--  <li role="presentation"><a href="#" style="color:rgb(255,255,255);"><i class="glyphicon glyphicon-bell" style="font-size:21px;"></i></a></li>  --}}
                        <li role="presentation"><a href="/settings" style="color:rgb(255,255,255);">Settings </a></li>
                        <li role="presentation"><a href="/logout" style="color:rgb(255,255,255);">Logout </a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-left">
                        <li role="presentation"><a href="#" style="color:rgb(255,255,255);"> </a></li>
                    </ul>
            </div>
    </div>
    </nav>
    </div>
    <section style="background-color:#f6f7f8;padding:8px;">
        <div class="dropdown"><button class="btn btn-default dropdown-toggle text-dropdown" data-toggle="dropdown" aria-expanded="false" type="button">Repositories </button>
            <ul class="dropdown-menu" role="menu">
                <li role="presentation"><a href="/home">Public </a></li>
                <li role="presentation">
                    @if(Auth::user()->subscribedToPlan(['private', 'organization']))
                        <a href="/home/private">
                            Private
                        </a>
                    @else
                        <a>
                            Private
                            <span class="label label-info">Public Plan</span>
                        </a>
                    @endif
                </li>
                <li role="presentation">

                    @if(Auth::user()->subscribedToPlan(['organization']))
                        <a href="/home/organization">Organization</a>
                    @else
                        <a>
                            Organization
                            <span class="label label-info">Organization Plan</span>
                        </a>
                        
                    @endif
                    
                </li>
            </ul>
        </div>
    </section>

    @yield('content')

    <script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>

</html>