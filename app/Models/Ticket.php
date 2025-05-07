<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_ticket_id',
        'number',
        'user_id',
        'status_id',
        'dept_id',
        'sla_id',
        'topic_id',
        'source',
        'est_duedate',
        'tkt_billeteadulterado',
        'subject',
        'priority',
        'tkt_fhsolicitud',
        'falla_reportada',
        'id_equipo',
        'serie',
        'activo'
    ];

    protected $casts = [
        'est_duedate' => 'datetime',
        'tkt_fhsolicitud' => 'datetime'
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function status()
    // {
    //     return $this->belongsTo(Status::class);
    // }

    // public function department()
    // {
    //     return $this->belongsTo(Department::class, 'dept_id');
    // }

    // public function sla()
    // {
    //     return $this->belongsTo(Sla::class);
    // }

    // public function topic()
    // {
    //     return $this->belongsTo(Topic::class);
    // }
}
