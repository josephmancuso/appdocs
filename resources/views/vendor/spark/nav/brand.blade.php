<a class="navbar-brand" href="http://{{ env('APP_URL') }}/home">
    @if(isset($repository))
        {{ $repository->name }}
    @else
        {{ env('APP_NAME') }}
    @endif
</a>
