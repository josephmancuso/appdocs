@extends('themes/cleanblue/base')

@section('section_left')
@include('themes.cleanblue.partials.pages')
@endsection

@section('section_right')
<h1>{{ str_replace('-', ' ', $title) }}</h1>

<div class="panel-body">
    @foreach($results as $filename => $resultList)
        <h3> {{ $filename }} </h3><hr>
        @foreach($resultList as $result)
        <div><a class="navbar-link" style="color: black" href="/{{ str_replace('.md', '', "docs/$filename") }}?q={{ $searchQuery }}"> {!! $result !!} </a></div><br>
        @endforeach
    @endforeach

    @unless($results)
        No Results Found matching "{{ $searchQuery }}"
    @endunless
</div>
@endsection