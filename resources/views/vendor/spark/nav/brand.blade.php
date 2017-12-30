<a class="navbar-brand" href="http://orderinghero.com/home">
    @if(isset($repository))
        {{ $repository->name }}
    @else
        {{ 'Orderinghero.com' }}
    @endif
</a>
