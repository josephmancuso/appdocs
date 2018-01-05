@extends('themes/cleanblue/base')

@section('section_left')

@include('themes.cleanblue.partials.pages')

@endsection

@section('section_right')
    <h1> {{ str_replace('-', ' ', $title) }}</h1>
    <hr style="margin-left:-10px;">
    {!! $code !!}
@endsection