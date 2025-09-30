<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketHistorial extends Model
{
    use HasFactory;

    public const ACCION_DERIVADO   = 'Derivado';
    public const ACCION_CERRADO    = 'Cerrado';
    public const ACCION_PAUSADO    = 'Pausado';
    public const ACCION_ACTUALIZADO= 'Actualizado';

    protected $table = 'ticket_historial';

    protected $fillable = [
        'ticket_id',
        'usuario_id',
        'from_area_id',
        'to_area_id',
        'asignado_a',
        'estado_id',
        'accion',
        'is_current',
        'comentario',
        'started_at',
        'ended_at',
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

    public function archivos()
    {
        return $this->morphMany(File::class, 'fileable');   
    }
}
