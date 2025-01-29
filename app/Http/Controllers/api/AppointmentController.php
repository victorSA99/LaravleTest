<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Create a new appointment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'date' => 'required|date|after:today',
            'time' => 'required|date_format:H:i',
            'description' => 'required|string|max:255',
            'user_id' => 'user_id,' . Auth::id(),
            'status' => 'in:pendiente,confirmada,cancelada',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $appointment = Appointment::create([
            'date' => $request->date,
            'time' => $request->time,
            'description' => $request->description,
            'status' => $request->status ?? AppointmentStatus::Pending->value,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Cita creada con éxito',
            'appointment' => $appointment
        ], 201);
    }



    public function getUserAppointments()
    {

        $appointments = Appointment::where('user_id', Auth::id())->get();


        if ($appointments->isEmpty()) {
            return response()->json(['message' => 'No appointments found for this user.'], 404);
        }

        return response()->json([
            'appointments' => $appointments
        ], 200);
    }

    public function getAllAppointments()
    {

        $appointments = Appointment::with('user')->get();

        if ($appointments->isEmpty()) {
            return response()->json(['message' => 'No appointments found.'], 404);
        }

        return response()->json([
            'appointments' => $appointments
        ], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);


        $request->validate([
            'status' => 'required|string|in:confirmada,pendiente,cancelada',
        ]);

        $status = $request->input('status');


        $appointment->status = $status;
        $appointment->save();

        return response()->json([
            'message' => 'Estado actualizado correctamente',
            'appointment' => $appointment
        ], 201);
    }



    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Validar los datos enviados en la solicitud
        $request->validate([
            'date' => 'required|date|after:today',
            'time' => 'required|date_format:H:i',
            'status' => 'nullable|string|in:confirmada,pendiente,cancelada', // status es opcional aquí
        ]);


        if ($request->has('date')) {
            $appointment->date = $request->input('date');
        }

        if ($request->has('time')) {
            $appointment->time = $request->input('time');
        }

        if ($request->has('status')) {
            $appointment->status = $request->input('status');
        }

        // Guardar los cambios
        $appointment->save();

        // Responder con éxito
        return response()->json([
            'message' => 'Cita actualizada correctamente',
            'appointment' => $appointment
        ], 200);
    }

    public function destroy($id)
    {

        $appointment = Appointment::findOrFail($id);

        $appointment->delete();

        return response()->json([
            'message' => 'Estado Eliminado correctamente',
        ], 200);
    }
}
