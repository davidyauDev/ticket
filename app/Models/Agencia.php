<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agencia extends Model
{
      use HasFactory;

    protected $fillable = ['id','nombre', 'cliente_id'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
