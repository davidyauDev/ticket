<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tecnico extends Model
{
    protected $table = 'tecnicos';

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'staff_id', 'staff_id');
    }
}
