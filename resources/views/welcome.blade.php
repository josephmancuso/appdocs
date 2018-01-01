@extends('spark::layouts.app')

@section('content')
   <div class="container">
        <div class="row">
            <div class="panel panel-success">
                <div class="panel-body">
                    <h2 class="text-center">Easily host and maintain documentation for your GitHub Repos</h2>
                    <hr>

                    <h3>How It Works:</h3>

                    <p>
                        <ul>
                            <li>Simply <a href="/login" class="btn btn-success">Sign in </a> with your GitHub account</li>
                            <li>Connect your repository</li>
                            <li>View your documentation hosted at this site</li>
                            <li>You can then choose which directory on GitHub your documentation is in (<code>docs/</code> by default)</li>
                        </ul>
                    </p>

                    <p>
                        <b>You may also add a webhook to your repository to maintain your documentation and versions when you do things like pushes and releases</b>
                    </p>
                </div>
            </div>
        </div>
   </div>
@endsection
