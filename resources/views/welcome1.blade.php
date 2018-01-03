@extends('base')

@section('content')
    <section style="background-color:#2ba0cb;height:100vh;padding-top:20vh;background-image:url(&quot;themes/cleanblue/img/header_image.jpg&quot;);margin-top:-10vh;">
        <h1 class="text-center" style="color:rgb(255,255,255);margin-top:0;padding-bottom:5vh;">Documentation Made Easy</h1>
        <h3 class="text-center" style="color:rgb(255,255,255);">The easiest way to host documentation.</h3>
        <h3 class="text-center" style="color:rgb(255,255,255);">1. Sign in</h3>
        <h3 class="text-center" style="color:rgb(255,255,255);">2. Add Your Repo</h3>
        <h3 class="text-center" style="color:rgb(255,255,255);">3. Done </h3>
        <div>
            <div class="row">
                <div class="col-md-12 text-center" style="padding-top:10vh;">
                    <a href="/login">
                        <button class="btn btn-link border-pretty" type="button" style="color:#ffffff;border:2px solid white;padding:10px 24px;font-size:24px;"><i class="fa fa-book"></i> Get Started</button>
                    </a>
                    <a href="http://masonite.{{ env('SUBDOMAIN_URL') }}">
                        <button class="btn btn-link border-pretty" type="button"
                        style="color:#ffffff;border:2px solid white;padding:10px 24px;font-size:24px;margin-left:10px;"><i class="fa fa-cloud"></i> Demo </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section>
        <h1 class="text-center">How It Works</h1>
        <hr>
        <h3 class="text-center">Documentation should be easy, fun, and convenient. </h3>
        <h3 class="text-center">Just put Markdown files in your repo, then tell us which directory it is (docs/ by default) and we will host your documentation with an elegant theme.</h3>
        <h3 class="text-center">When you push, we will update your documentation. When you release, we will version it. Control all updating of your docs in your repo and we'll keep everything up to date.</h3>
        <p> </p>
    </section>
@endsection

