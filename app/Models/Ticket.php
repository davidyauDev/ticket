<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'asunto',
        'comentario',
        'observacion_id',
        'observacion_consulta',
        'falla_reportada',
        'equipo_id',
        'agencia_id',
        'tecnico_dni',
        'estado_id',
        'tipo',
        'tecnico_nombres',
        'tecnico_apellidos',
        'area_id',
        'assigned_to',
        'created_by',
    ];

    public function historiales()
    {
        return $this->hasMany(TicketHistorial::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function agencia()
    {
        return $this->belongsTo(Agencia::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function archivos()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function observacion()
    {
        return $this->belongsTo(Observacion::class);
    }

    public function getCodigoFormateadoAttribute(): string
{
    return 'TCK-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
}


}
