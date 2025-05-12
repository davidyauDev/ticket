<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = ['serie', 'modelo'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
