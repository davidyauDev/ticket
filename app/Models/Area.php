<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }


    public function historialesDesdeArea()
    {
        return $this->hasMany(TicketHistorial::class, 'from_area_id');
    }

    public function historialesHaciaArea()
    {
        return $this->hasMany(TicketHistorial::class, 'to_area_id');
    }
    public function parent()
    {
        return $this->belongsTo(Area::class, 'parent_id');
    }
}
