<div class="mb-3">
    <label for="{{ $config["id"] }}" class="form-label">{{ $label }}</label>
    <textarea class="form-control" id="{{ $config["id"] }}" name="{{ $config["id"] }}" rows="3">@if($entry != null && $entry[$config["value"]]){{ implode("\n", $entry[$config["value"]]) }}@endif</textarea>
</div>
