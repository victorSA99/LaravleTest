<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AppointmentStatus;

class Appointment extends Model
{
    use HasFactory;

    protected $attributes = [
        'status' => AppointmentStatus::Pending->value,
    ];

    protected $fillable = ['date', 'time', 'description', 'user_id', 'status', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $table = 'appointment';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function getStatuses()
    {
        return AppointmentStatus::cases();
    }
}
