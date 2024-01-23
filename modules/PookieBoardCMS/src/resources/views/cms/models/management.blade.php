<a class="btn btn-warning" href="{{ route("cms.model.edit", ["model" => $modelName, "id" => $model->id]) }}">
    <i class="fa-solid fa-pen-to-square"></i>
    <span class="d-none d-md-inline">Edit</span>
</a>
<a class="btn btn-danger" href="{{ route("cms.model.delete", ["model" => $modelName, "id" => $model->id]) }}">
    <i class="fa-solid fa-trash"></i>
    <span class="d-none d-md-inline">Delete</span>
</a>
