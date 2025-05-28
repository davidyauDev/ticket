<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    protected $table = 'observaciones';  
    protected $fillable = ['descripcion'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
