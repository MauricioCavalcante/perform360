<div>
    <label for="{{ $attributes->get('id') }}">{{ $label }}</label>
    <select {{ $attributes->merge(['class' => 'form-control']) }}>
        {{ $slot }}
    </select>
</div>