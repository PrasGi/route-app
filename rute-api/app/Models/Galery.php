<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galery extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id'];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
