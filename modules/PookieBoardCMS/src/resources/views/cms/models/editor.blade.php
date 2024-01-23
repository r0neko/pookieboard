@extends('cms.page.base')

@section('heading', ($entry == null ? "New " : "Edit ") . $model)

@section('content')
    <div class="alert alert-warning">
        <b>Important:&nbsp;</b>The 'media' upload fields are currently work-in-progress, so you may be limited to just
        editing other fields that are supported by the CMS.
    </div>
    <form
        action="{{ route($entry == null ? "cms.model.new" : "cms.model.edit", ["model" => $model, "id" => $entry ? $entry->id : 0]) }}"
        method="post">
        @foreach($fields as $label => $config)
            @include("cms.models.field-types." . $config["type"], ["label" => $label, "config" => $config])
        @endforeach
        <br>
        <button type="submit" class="btn btn-info">Save</button>
        <br>
    </form>
@endsection
