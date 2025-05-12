<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = ['id','nombre'];

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
}
