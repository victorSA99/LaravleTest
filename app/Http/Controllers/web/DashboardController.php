<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query();

        // Filtrado por estado
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filtrado por nombre del usuario
        if ($request->has('user_name') && !empty($request->user_name)) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        // Obtener citas con paginación
        $appointments = $query->paginate(5);

        // Obtener todos los estados para el select
        $appointmentStatuses = AppointmentStatus::cases();

        return view('dashboard.dashboard', compact('appointments', 'appointmentStatuses'));
    }
}
