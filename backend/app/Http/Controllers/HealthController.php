<?php

namespace App\Http\Controllers;

use App\Models\HealthRecord;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HealthController extends Controller
{
    public function index(Request $request)
    {
        $healthRecords = $request -> user()
             -> healthRecords()
             -> orderBy('year')
             -> orderBy('month')
             -> get();

        // Transform data to match frontend structure
        $diagnosisHistory = $healthRecords -> map(function ($record) {
            return [
                'id' => $record -> id,
                'month' => $record -> month,
                'year' => $record -> year,
                'blood_pressure' => [
                    'systolic' => [
                        'value' => $record -> systolic,
                        'levels' => $record -> systolic_level,
                    ],
                    'diastolic' => [
                        'value' => $record -> diastolic,
                        'levels' => $record -> diastolic_level,
                    ],
                ],
                'respiratory_rate' => [
                    'value' => $record -> respiratory_rate,
                    'levels' => $record -> respiratory_level,
                ],
                'temperature' => [
                    'value' => $record -> temperature,
                    'levels' => $record -> temperature_level,
                ],
                'heart_rate' => [
                    'value' => $record -> heart_rate,
                    'levels' => $record -> heart_rate_level,
                ],
            ];
        });

        return response() -> json([
            'diagnosis_history' => $diagnosisHistory,
        ]);
    }

    public function show(Request $request, $id)
    {
        $healthRecord = $request -> user()
             -> healthRecords()
             -> findOrFail($id);

        return response() -> json([
            'id' => $healthRecord -> id,
            'month' => $healthRecord -> month,
            'year' => $healthRecord -> year,
            'blood_pressure' => [
                'systolic' => [
                    'value' => $healthRecord -> systolic,
                    'levels' => $healthRecord -> systolic_level,
                ],
                'diastolic' => [
                    'value' => $healthRecord -> diastolic,
                    'levels' => $healthRecord -> diastolic_level,
                ],
            ],
            'respiratory_rate' => [
                'value' => $healthRecord -> respiratory_rate,
                'levels' => $healthRecord -> respiratory_level,
            ],
            'temperature' => [
                'value' => $healthRecord -> temperature,
                'levels' => $healthRecord -> temperature_level,
            ],
            'heart_rate' => [
                'value' => $healthRecord -> heart_rate,
                'levels' => $healthRecord -> heart_rate_level,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request -> validate([
            'month' => 'required|string',
            'year' => 'required|string',
            'systolic' => 'required|integer',
            'systolic_level' => 'required|string',
            'diastolic' => 'required|integer',
            'diastolic_level' => 'required|string',
            'respiratory_rate' => 'required|integer',
            'respiratory_level' => 'required|string',
            'temperature' => 'required|numeric',
            'temperature_level' => 'required|string',
            'heart_rate' => 'required|integer',
            'heart_rate_level' => 'required|string',
        ]);

        $validated['user_id'] = $request -> user() -> id;

        $healthRecord = HealthRecord::create($validated);

        return response() -> json($healthRecord, 201);
    }
}
