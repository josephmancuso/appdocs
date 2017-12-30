@extends('themes/cleanblue/base')

@section('section_left')
<ul class="nav nav-pills nav-stacked">
    @foreach($pages as $page)
        @if(isset($currentVersion))
            <li role="presentation"><a href="/v/{{ $currentVersion }}/{{ str_replace('.md', '', $page) }}">{{ str_replace('.md', '', str_replace('-', ' ', $page)) }}</a></li>
        @else
            <li role="presentation"><a href="/docs/{{ str_replace('.md', '', $page) }}">{{ str_replace('.md', '', str_replace('-', ' ', $page)) }}</a></li>
        @endif
        
    @endforeach
</ul>
@endsection

@section('section_right')
    <h1> {{ str_replace('-', ' ', $title) }}</h1>
    <hr style="margin-left:-10px;">
    {!! $code !!}
@endsection