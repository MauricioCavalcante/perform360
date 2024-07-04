<div>
    <input {{ $attributes->merge(['class' => 'form-checkbox']) }} type="checkbox" {{ $checked ? 'checked' : '' }}>
    {{ $slot }}
</div>
