<div class="mb-3">
    <label for="{{ $config["id"] }}" class="form-label">{{ $label }}</label>
    <input
        class="form-control"
        id="{{ $config["id"] }}"
        name="{{ $config["id"] }}"
        @if($entry != null && $entry[$config["value"]])
            value="{{ $entry[$config["value"]] }}"
        @endif
    >
</div>
