<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketArchivo extends Model
{
    protected $fillable = [
        'nombre_original',
        'ruta',
        'ticket_id',
        'ticket_historial_id',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function historial() 
    {
        return $this->belongsTo(TicketHistorial::class, 'ticket_historial_id');
    }
}
