<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = ['serie', 'modelo' , 'id_equipo' , 'modelo_id'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    
    /**
     * Get the modelo that owns the equipo.
     */
    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }
}
