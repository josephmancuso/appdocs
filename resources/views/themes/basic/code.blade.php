@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Versions</div>

                <div class="panel-body">
                    <label for="versions">Select a Version</label>
                    
                    <select id="select-menu" class="form-control">
                        @if(isset($currentVersion))
                            <option>{{ $currentVersion }} </option>
                        @else
                            <option disabled selected>{{ $repository->default_version }}</option>
                        @endif
                        
                        @foreach($versions as $version)
                            <option value="/v/{{ $version }}">{{ $version }}</option>
                        @endforeach
                    </select>
                    
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Search Documentation</div>

                <div class="panel-body">
                <form action="/search/{{ $currentVersion ?? 'current' }}" method="GET">
                    <div class="form-group text-center">
                        <input type="text" name="q" placeholder="Enter search keywords ..." class="form-control">
                        <br>
                        <button class="btn btn-primary">Search</button>
                    </div>
                </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                Navigation
                </div>

                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                        @foreach($pages as $page)
                            @if(isset($currentVersion))
                                <li role="presentation"><a href="/v/{{ $currentVersion }}/{{ str_replace('.md', '', $page) }}">{{ str_replace('.md', '', str_replace('-', ' ', $page)) }}</a></li>
                            @else
                                <li role="presentation"><a href="/docs/{{ str_replace('.md', '', $page) }}">{{ str_replace('.md', '', str_replace('-', ' ', $page)) }}</a></li>
                            @endif
                            
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-8">
            <div class="panel panel-default">

                <div class="panel-heading">
                    {{ str_replace('-', ' ', $title) }}
                </div>

                <div class="panel-body">
                    {!! $code !!}
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
<script   src="https://code.jquery.com/jquery-3.2.1.slim.min.js"   integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g="   crossorigin="anonymous"></script>
<script>
$(function(){
      // bind change event to select
      $('#select-menu').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
</script>
@endsection