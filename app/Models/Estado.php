<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estados';

    public const PENDIENTE = 1;
    public const DERIVADO  = 2;
    public const CERRADO   = 5;
    public const PAUSADO   = 6;

    protected $fillable = ['nombre', 'descripcion'];
    public function ticketHistorials()
    {
        return $this->hasMany(TicketHistorial::class, 'estado_id');
    }
}
