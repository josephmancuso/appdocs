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
            Great! You're repository has been verified. Just add this webhook: <code>http://a4997ff6.ngrok.io/hook</code> to your <a href="{{ $singleRepo['html_url'].'/settings/hooks/new' }}">settings page</a>. Make sure its <code>json</code> as the content type.
            We just need the <code>gollumn</code>, <code>release</code> and <code>push</code> events but you can just click <code>Just send me everything</code> to get new features as we add implementations
        </p>

        <p>
            You can view your documentation at: <a href="http://{{ $repository->name }}.appdoc.test">http://{{ $repository->name }}.appdoc.test</a>
        </p>
    </div>
</div>
@endsection