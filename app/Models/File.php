<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['nombre_original', 'ruta'];

    public function archivos()
    {
        return $this->morphTo();
    }
}