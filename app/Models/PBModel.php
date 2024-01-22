<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

// base model class which uses an UUIDv4-based indexing style
class PBModel extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
