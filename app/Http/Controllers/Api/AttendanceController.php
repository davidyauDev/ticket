<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'timestamp'             => 'required|date_format:Y-m-d H:i:s',
            'latitude'              => 'required|numeric',
            'longitude'             => 'required|numeric',
            'notes'                 => 'nullable|string',
            'device_model'           => 'required|string',
            'battery_percentage'     => 'required|integer|min:0|max:100',
            'signal_strength'        => 'required|integer|min:0|max:4',
            'network_type'           => 'required|string',
            'is_internet_available'  => 'required|boolean',
            'type'                  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors(),
            ], 422);
        }
        $attendance = new Attendance($validator->validated());
        $attendance->user()->associate($request->user()); 
        $attendance->save();
        return response()->json([
            'message'   => 'Registro de asistencia guardado',
            'data'      => $attendance,
        ], 201);
    }
}
