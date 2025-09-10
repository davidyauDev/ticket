<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    protected $table = 'modelos';
    protected $fillable = ['descripcion'];
        /**
         * Get the equipos for the modelo.
         */
        public function equipos()
        {
            return $this->hasMany(Equipo::class);
        }
}
