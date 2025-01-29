<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Pending = 'pendiente';
    case Confirmed = 'confirmada';
    case Cancelled = 'cancelada';
}
