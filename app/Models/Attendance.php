<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'timestamp',
        'latitude',
        'longitude',
        'notes',
        'device_model',
        'battery_percentage',
        'battery_strength',
        'signal_strength',
        'network_type',
        'is_internet_available',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
