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
    <form action="/home/repo/{{ $repository->repo_id }}" method="POST">
    {{ csrf_field() }}
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $repository->name }}">
        </div>

        <div class="form-group">
            <label for="">Is Wiki?</label>
            @if($repository->wiki)
                <input type="checkbox" name="is_wiki" checked>  
            @else
                <input type="checkbox" name="is_wiki">  
            @endif
            
        </div>

        <div class="form-group">
            <button class="btn btn-success">
                Update
            </button>
        </div>
    </form>
    </div>
</div>
@endsection