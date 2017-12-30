@extends('spark::layouts.app')

@extends('base.home')

@section('section_left')
    @include('partials.repositories')
@endsection

@section('section_right')
<div class="panel panel-default">
    <div class="panel-heading"> Detail {{ $singleRepo['name'] }} </div>

    <div class="panel-body">
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message')}}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error')}}
        </div>
    @endif

    <form action="/home/repo/{{ $repository->repo_id }}" method="POST">
    {{ csrf_field() }}
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $repository->name }}">
        </div>

        {{--
        <div class="form-group">
            <label for="">Is Wiki?</label>
            @if($repository->wiki)
                <input type="checkbox" name="is_wiki" checked>  
            @else
                <input type="checkbox" name="is_wiki">  
            @endif
        </div>
        --}}

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

        <div class="form-group">
            <label>Documentation Location</label>

            <input type="text" class="form-control" name="docs_location" value="{{ $repository->docs_location }}" pattern="^([a-zA-Z0-9]+[\/]?)+[^\/]$" title="Pattern should not have a trailing slash. Input should look like: directory/docs and not: directory/docs/">
            <div class="help-block">Format should be either: docs or directory/docs. It should not have a trailing slash</div>
        </div>
        <div class="form-group">
            <button class="btn btn-success">
                Update
            </button>
        </div>
    </form>
    </div>
</div> <!-- ./ Detail Panel -->

<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading"> Manually Download Repo Documentation</div>

        <div class="panel-body">
            <p>
                There is a short 5 minute-ish delay in when the updated repository documentation can be retrieved after a <code>push</code>. If you find there that your documentation
                is not updating when you push, verify that you have correctly setup the webhook to your repo and that there are no errors (there will be a little red triangle next to the webhook in your repo settings). 
                Remember that the webhook should have a Content Type of <code>application/json</code> and select <code>Send me <b>everything</b></code> for the events.
            </p>

            <p>
                If everything above is correct, then when our server attempted to retrieve your documentation then GitHub sent us outdated information. If it has been at least 5 minutes since your last push, try to allow our servers to manually download the repo again
            </p>

            <div class="form-group">
            <form action="/repo/download" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="repo_id" value="{{ $repository->repo_id }}">
                <button type="submit" class="btn btn-primary">Manually Download</button>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection