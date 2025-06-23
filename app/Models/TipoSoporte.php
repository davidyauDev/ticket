<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSoporte extends Model
{
    protected $table = 'tipos_soporte';

    protected $fillable = [
        'nombre',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'tipo_soporte_id');
    }
}
