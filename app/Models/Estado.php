<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estados';

    protected $fillable = ['nombre', 'descripcion'];
    public function ticketHistorials()
    {
        return $this->hasMany(TicketHistorial::class, 'estado_id');
    }
}
