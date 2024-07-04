@props(['message' => null])

@if ($message)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $message as $msg)
            <li>{{ $msg }}</li>
        @endforeach
    </ul>
@endif
