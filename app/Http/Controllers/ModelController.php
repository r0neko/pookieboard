<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Ramsey\Uuid\Uuid;

class ModelController extends Controller
{
    public function showAll($model)
    {
        $models = app('cms.models');
        $type = $models->getModel($model);

        if (!$type) {
            abort(404);
        }

        $modelAll = $type::all();
        $tableMapping = $type::$tableMapping;

        if (!$tableMapping) {
            abort(404);
        }

        $tableMapping = array_merge($tableMapping, ["#Management" => fn($m) => view("cms.models.management", ["modelName" => $model, "model" => $m])]);

        $keys = array_keys($tableMapping);
        $values = array_values($tableMapping);

        $finalValues = [];

        foreach ($modelAll as $_model) {
            $val = [];

            foreach ($values as $_prop) {
                $ret = is_callable($_prop) ? $_prop($_model) : $_model[$_prop];
                $val[] = $ret ?: '-';
            }

            $finalValues[] = $val;
        }

        return view("cms.models.list", [
            "model" => $model,
            "columns" => $keys,
            "values" => $finalValues
        ]);
    }

    public function delete($model, $id, Request $request)
    {
        $models = app('cms.models');
        $type = $models->getModel($model);

        if (!$type) {
            abort(404);
        }

        $modelEntry = $type::find(Uuid::fromString($id));

        // if the model doesn't exist, we say it can't be found
        if (!$modelEntry) {
            abort(404);
        }

        $modelEntry->delete();

        $request->session()->flash('cms.alert.success', 'Entry successfully deleted!');

        return redirect(route("cms.model.all", ["model" => $model]));
    }

    public function saveModel($model, $id = null, Request $request)
    {
        $models = app('cms.models');
        $type = $models->getModel($model);

        if (!$type) {
            abort(404);
        }

        $modelEntry = $id != null ? $type::find(Uuid::fromString($id)) : null;

        if ($modelEntry == null) {
            $modelEntry = new $type;
        }

        $fields = $type::$formFields ?: [];

        foreach ($fields as $key => $field) {
            $value = $request->get($field["id"]);

            switch ($field["type"]) {
                case "text":
                    data_set($modelEntry, $field["value"], $value);
                    break;
                case "text-list":
                    data_set($modelEntry, $field["value"], json_encode(explode("\n", $value)));
                    break;
                default:
//                    dump($field, $value);
                    break;
            }
        }

        $modelEntry->save();

        $request->session()->flash('cms.alert.success', 'Entry successfully saved!');

        return redirect(route("cms.model.all", ["model" => $model]));
    }

    public function modelEditor($model, $id = null)
    {
        $models = app('cms.models');
        $type = $models->getModel($model);

        if (!$type) {
            abort(404);
        }

        $modelEntry = null;
        if ($id != null) {
            $modelEntry = $type::find(Uuid::fromString($id));

            // if the model doesn't exist, we say it can't be found
            if (!$modelEntry) {
                abort(404);
            }
        }

        $fields = $type::$formFields ?: [];

        return view("cms.models.editor", [
            "model" => $model,
            "entry" => $modelEntry,
            "fields" => $fields
        ]);
    }
}
