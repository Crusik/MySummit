<?php

namespace App\Http\Controllers;

use App\Models\LabResult;
use Illuminate\Http\Request;

class LabResultController extends Controller
{
    /**
     * Display a listing of lab results for the authenticated user.
     */
    public function index()
    {
        $labResults = LabResult::where('user_id', auth('sanctum') -> user() -> id)
             -> orderBy('test_date', 'desc')
             -> get();

        return response() -> json($labResults);
    }

    /**
     * Store a newly created lab result in storage.
     */
    public function store(Request $request)
    {
        $validated = $request -> validate([
            'test_name' => 'required|string',
            'description' => 'nullable|string',
            'test_type' => 'required|string',
            'test_date' => 'required|date',
            'results_received_date' => 'nullable|date',
            'status' => 'required|in:pending,completed,reviewed',
            'result_value' => 'nullable|string',
            'unit' => 'nullable|string',
            'reference_range' => 'nullable|string',
            'provider_notes' => 'nullable|string',
        ]);

        $labResult = LabResult::create([
            'user_id' => auth('sanctum') -> user() -> id,
            ...$validated,
        ]);

        return response() -> json($labResult, 201);
    }

    /**
     * Display the specified lab result.
     */
    public function show(LabResult $labResult)
    {
        if ($labResult -> user_id !== auth('sanctum') -> user() -> id) {
            abort(403, 'Unauthorized');
        }
        return response() -> json($labResult);
    }

    /**
     * Update the specified lab result in storage.
     */
    public function update(Request $request, LabResult $labResult)
    {
        if ($labResult -> user_id !== auth('sanctum') -> user() -> id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request -> validate([
            'test_name' => 'sometimes|string',
            'description' => 'nullable|string',
            'test_type' => 'sometimes|string',
            'test_date' => 'sometimes|date',
            'results_received_date' => 'nullable|date',
            'status' => 'sometimes|in:pending,completed,reviewed',
            'result_value' => 'nullable|string',
            'unit' => 'nullable|string',
            'reference_range' => 'nullable|string',
            'provider_notes' => 'nullable|string',
        ]);

        $labResult -> update($validated);

        return response() -> json($labResult);
    }

    /**
     * Remove the specified lab result from storage.
     */
    public function destroy(LabResult $labResult)
    {
        if ($labResult -> user_id !== auth('sanctum') -> user() -> id) {
            abort(403, 'Unauthorized');
        }
        $labResult -> delete();

        return response() -> json(null, 204);
    }
}
