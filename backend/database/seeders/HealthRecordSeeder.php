<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HealthRecord;
use Carbon\Carbon;

class HealthRecordSeeder extends Seeder
{
    public function run()
    {
        // Get Michael by ID
        $michael = \App\Models\User::find(1);

        if ($michael) {
            // Michael's health records for the last 6 months
            $months = [
                ['month' => 'May', 'year' => '2025'],
                ['month' => 'June', 'year' => '2025'],
                ['month' => 'July', 'year' => '2025'],
                ['month' => 'August', 'year' => '2025'],
                ['month' => 'September', 'year' => '2025'],
                ['month' => 'October', 'year' => '2025'],
            ];

            $readings = [
                ['systolic' => 118, 'diastolic' => 76, 'respiratory' => 16, 'temp' => 98.6, 'heart' => 72],
                ['systolic' => 120, 'diastolic' => 78, 'respiratory' => 17, 'temp' => 98.4, 'heart' => 74],
                ['systolic' => 122, 'diastolic' => 80, 'respiratory' => 16, 'temp' => 98.7, 'heart' => 76],
                ['systolic' => 119, 'diastolic' => 77, 'respiratory' => 15, 'temp' => 98.5, 'heart' => 73],
                ['systolic' => 121, 'diastolic' => 79, 'respiratory' => 16, 'temp' => 98.6, 'heart' => 75],
                ['systolic' => 123, 'diastolic' => 81, 'respiratory' => 17, 'temp' => 98.8, 'heart' => 77],
            ];

            foreach ($months as $index => $monthData) {
                $reading = $readings[$index];
                
                HealthRecord::create([
                    'user_id' => $michael->id,
                    'month' => $monthData['month'],
                    'year' => $monthData['year'],
                    'systolic' => $reading['systolic'],
                    'systolic_level' => 'Normal',
                    'diastolic' => $reading['diastolic'],
                    'diastolic_level' => 'Normal',
                    'respiratory_rate' => $reading['respiratory'],
                    'respiratory_level' => 'Normal',
                    'temperature' => $reading['temp'],
                    'temperature_level' => 'Normal',
                    'heart_rate' => $reading['heart'],
                    'heart_rate_level' => 'Normal',
                ]);
            }
        }

        // Get Lisa by ID
        $lisa = \App\Models\User::find(5);

        if ($lisa) {
            // Lisa's health records for the last 6 months
            $readings = [
                ['systolic' => 116, 'diastolic' => 74, 'respiratory' => 15, 'temp' => 98.5, 'heart' => 68],
                ['systolic' => 118, 'diastolic' => 76, 'respiratory' => 16, 'temp' => 98.3, 'heart' => 70],
                ['systolic' => 120, 'diastolic' => 78, 'respiratory' => 15, 'temp' => 98.6, 'heart' => 72],
                ['systolic' => 117, 'diastolic' => 75, 'respiratory' => 15, 'temp' => 98.4, 'heart' => 69],
                ['systolic' => 119, 'diastolic' => 77, 'respiratory' => 16, 'temp' => 98.5, 'heart' => 71],
                ['systolic' => 121, 'diastolic' => 79, 'respiratory' => 16, 'temp' => 98.7, 'heart' => 73],
            ];

            foreach ($months as $index => $monthData) {
                $reading = $readings[$index];
                
                HealthRecord::create([
                    'user_id' => $lisa->id,
                    'month' => $monthData['month'],
                    'year' => $monthData['year'],
                    'systolic' => $reading['systolic'],
                    'systolic_level' => 'Normal',
                    'diastolic' => $reading['diastolic'],
                    'diastolic_level' => 'Normal',
                    'respiratory_rate' => $reading['respiratory'],
                    'respiratory_level' => 'Normal',
                    'temperature' => $reading['temp'],
                    'temperature_level' => 'Normal',
                    'heart_rate' => $reading['heart'],
                    'heart_rate_level' => 'Normal',
                ]);
            }
        }
    }
}
