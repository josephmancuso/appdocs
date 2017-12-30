@extends('spark::layouts.app')

@extends('base.home')

@section('section_left')
    @include('partials.repositories')
@endsection

@section('section_right')
<div class="panel panel-default">
    <div class="panel-heading"> Add {{ $singleRepo['name'] }} </div>

    <div class="panel-body">
        <p>
            Great! You're repository has been verified. Just add this webhook: <code>http://orderinghero.com/hook</code> to your <a href="{{ $singleRepo['html_url'].'/settings/hooks/new' }}">settings page</a>. Make sure its <code>application/json</code> as the content type.
            Just click <code>Just send me everything</code> to get new features as we add implementations
        </p>

        <p>
            You can view your documentation at: <a href="http://{{ $repository->name }}.orderinghero.com" target="_blank">http://{{ $repository->name }}.orderinghero.com</a>
        </p>
    </div>
</div>
@endsection