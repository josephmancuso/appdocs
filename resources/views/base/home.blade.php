@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                    </div>
                </div>
            </div>
        </div>

        <div class="rows">
            @yield('section_left')

            @yield('section_right')
        </div>
    </div>
</home>
@endsection