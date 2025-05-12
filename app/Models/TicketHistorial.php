<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketHistorial extends Model
{
    use HasFactory;

    // Definir la tabla explícitamente si no es la convención plural
    protected $table = 'ticket_historial';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'ticket_id',
        'usuario_id',
        'from_area_id',
        'to_area_id',
        'asignado_a',
        'estado_id',
        'accion',
        'is_current',
        'comentario'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function fromArea()
    {
        return $this->belongsTo(Area::class, 'from_area_id');
    }

    public function toArea()
    {
        return $this->belongsTo(Area::class, 'to_area_id');
    }

    public function asignadoA()
    {
        return $this->belongsTo(User::class, 'asignado_a');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }
}
