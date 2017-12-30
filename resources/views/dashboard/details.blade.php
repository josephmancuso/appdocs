@extends('dashboard.base')


@section('content')
    

    <h3 style="margin-left:23px;">{{ $singleRepo['name'] }} Details</h3>
    @if(session('message'))
        <div class="alert alert-success">
            {!! session('message') !!}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error')}}
        </div>
    @endif
    <hr>
    <div style="margin-top:20px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form action="/home/repo/{{ $repository->repo_id }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group" style="margin-bottom:1px;"><label>Url</label></div>
                        <div style="margin-bottom:7px;margin-top:-6px;"><a href="http://{{ $repository->name }}.{{ env('SUBDOMAIN_URL') }}" target="_blank">http://{{ $repository->name }}.{{ env('SUBDOMAIN_URL') }}</a></div>
                        <div class="form-group"><label>Name </label><input type="text" value="{{ $repository->name }}" name="name" required="" class="form-control"></div>
                        <div class="form-group">
                            <label>Default Version</label>
                            <select name="default_version" class="form-control">
                                @foreach($repoVersions as $version)
                                    @if ($version == $repository->default_version)
                                        <option selected value="{{ $repository->default_version }}">{{ $repository->default_version }}</option>
                                    @else
                                        <option value="{{ $version }}">{{ $version }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group"><label>Documentation Location</label><input type="text" value="{{ $repository->docs_location }}" name="docs_location" pattern="^([a-zA-Z0-9]+[\/]?)+[^\/]$" required="" class="form-control"></div>
                        <button class="btn btn-success" type="submit">Update </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h4>Manual Download</h4>
                    <p>
                        If you have done pushes in quick succession, GitHub will start to cache your files to third parties. If this is the case then there might be a short 5 minute-ish delay in when the updated repository documentation can be retrieved after the latest <code>push</code>. If you find there that your documentation
                        is not updating when you push, verify that you have correctly setup the webhook to your repo and that there are no errors (there will be a little red triangle next to the webhook in your repo settings). 
                        Remember that the webhook should have a Content Type of <code>application/json</code> and select <code>Send me <b>everything</b></code> for the events.
                    </p>

                    <p>
                        If everything above is correct, then when our server attempted to retrieve your documentation then GitHub sent us outdated information. If it has been at least 5 minutes since your last push, try to allow our servers to manually download the repo again
                    </p>
                        
                        <form action="/repo/download" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="repo_id" value="{{ $repository->repo_id }}">
                            <button type="submit" class="btn btn-primary">Manually Download</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <section style="padding-left:23px;">
        <h3>Webhook: http://orderinghero.com/hook</h3>
        <p style="padding-right:24px;">You may also put this webhook in the settings of your repo so we can maintain your documentation for you. Whenever you push to your repo, we will be able to update the documentation on this site. When you release, we save that version of your
            documentation.</p>
    </section>
@endsection