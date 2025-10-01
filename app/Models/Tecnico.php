<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Tecnico extends Model
{
    use HasFactory;

    protected $table = 'tecnicos';

    protected $fillable = [
        'staff_id',
        'firstname',
        'lastname',
        'name',
        'email',
        'dni',
        'direccion',
        'phone',
        'remember_token',
    ];

   
}
