<div>
    <input type="checkbox" class="btn-check" name="{{ $name }}" id="btncheck{{ $value }}" value="{{ $value }}" {{ $checked ? 'checked' : '' }}>
    <label class="btn btn-outline-dark" for="btncheck{{ $value }}">{{ $slot }}</label>
</div>