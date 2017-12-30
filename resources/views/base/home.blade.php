@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        

        <div class="row">
        <div class="col-xs-12 col-md-4">
            @yield('section_left')
        </div>

            @yield('section_right')
        </div>
    </div>
</home>
@endsection
