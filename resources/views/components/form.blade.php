@props(['action', 'post' => null, 'put' => null, 'delete' => null, 'patch' => null])

<form class="max-w-2xl mx-auto" action="{{ $action }}" method="POST">
    @csrf

    @if ($put)
        @method('PUT')
    @endif

    @if ($delete)
        @method('DELETE')
    @endif
    @if ($patch)
        @method('PATCH')
    @endif
    {{ $slot }}
</form>
