<?php

namespace Database\Seeders;

use App\Models\LabResult;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LabResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            return;
        }

        $testData = [
            [
                'test_name' => 'Complete Blood Count (CBC)',
                'description' => 'Measures red blood cells, white blood cells, and platelets',
                'test_type' => 'blood_work',
                'test_date' => Carbon::now() -> subDays(30),
                'results_received_date' => Carbon::now() -> subDays(28),
                'status' => 'reviewed',
                'result_value' => 'WBC: 7.2, RBC: 4.8, Hgb: 14.2',
                'unit' => 'K/µL, M/µL, g/dL',
                'reference_range' => 'WBC: 4.5-11.0, RBC: 4.5-5.9, Hgb: 13.5-17.5',
                'provider_notes' => 'All values within normal range. No concerns noted.',
            ],
            [
                'test_name' => 'Lipid Panel',
                'description' => 'Measures cholesterol and triglycerides',
                'test_type' => 'blood_work',
                'test_date' => Carbon::now() -> subDays(25),
                'results_received_date' => Carbon::now() -> subDays(23),
                'status' => 'reviewed',
                'result_value' => 'Total: 185, LDL: 110, HDL: 52, Triglycerides: 100',
                'unit' => 'mg/dL',
                'reference_range' => 'Total: <200, LDL: <130, HDL: >40, Triglycerides: <150',
                'provider_notes' => 'Excellent lipid profile. Continue current diet and exercise routine.',
            ],
            [
                'test_name' => 'Thyroid Function Test (TSH)',
                'description' => 'Measures thyroid stimulating hormone levels',
                'test_type' => 'blood_work',
                'test_date' => Carbon::now() -> subDays(20),
                'results_received_date' => Carbon::now() -> subDays(18),
                'status' => 'reviewed',
                'result_value' => '2.1',
                'unit' => 'mIU/L',
                'reference_range' => '0.4-4.0',
                'provider_notes' => 'Normal thyroid function. No medication adjustment needed.',
            ],
            [
                'test_name' => 'Comprehensive Metabolic Panel',
                'description' => 'Measures kidney function, liver function, and electrolytes',
                'test_type' => 'blood_work',
                'test_date' => Carbon::now() -> subDays(15),
                'results_received_date' => Carbon::now() -> subDays(13),
                'status' => 'reviewed',
                'result_value' => 'Glucose: 95, Creatinine: 0.9, AST: 28, ALT: 32',
                'unit' => 'mg/dL, mg/dL, U/L, U/L',
                'reference_range' => 'Glucose: 70-100, Creatinine: 0.7-1.3, AST: 10-40, ALT: 7-56',
                'provider_notes' => 'All metabolic values normal. Kidney and liver function optimal.',
            ],
            [
                'test_name' => 'HbA1c Test (Diabetes Screening)',
                'description' => 'Measures average blood sugar over 3 months',
                'test_type' => 'blood_work',
                'test_date' => Carbon::now() -> subDays(10),
                'results_received_date' => Carbon::now() -> subDays(8),
                'status' => 'reviewed',
                'result_value' => '5.2',
                'unit' => '%',
                'reference_range' => '<5.7',
                'provider_notes' => 'Excellent diabetes screening result. No indication of diabetes.',
            ],
            [
                'test_name' => 'Urinalysis',
                'description' => 'Examines urine for protein, glucose, and other substances',
                'test_type' => 'blood_work',
                'test_date' => Carbon::now() -> subDays(5),
                'results_received_date' => Carbon::now() -> subDays(4),
                'status' => 'reviewed',
                'result_value' => 'Clear, No glucose, No protein',
                'unit' => 'Visual inspection',
                'reference_range' => 'Clear, Negative, Negative',
                'provider_notes' => 'Normal urinalysis. No signs of infection or kidney disease.',
            ],
            [
                'test_name' => 'Chest X-Ray',
                'description' => 'Imaging study of chest and lungs',
                'test_type' => 'imaging',
                'test_date' => Carbon::now() -> subDays(2),
                'results_received_date' => Carbon::now() -> subDays(1),
                'status' => 'reviewed',
                'result_value' => 'No acute abnormalities',
                'unit' => 'Radiological findings',
                'reference_range' => 'Normal',
                'provider_notes' => 'Chest X-ray shows normal lung fields. Heart size normal. No evidence of pneumonia or other acute conditions.',
            ],
            [
                'test_name' => 'Vitamin D Level',
                'description' => 'Measures vitamin D (25-hydroxy) concentration',
                'test_type' => 'blood_work',
                'test_date' => Carbon::now() -> subDays(1),
                'results_received_date' => null,
                'status' => 'completed',
                'result_value' => 'Pending',
                'unit' => 'ng/mL',
                'reference_range' => '>30 (Optimal)',
                'provider_notes' => 'Test completed. Results being reviewed.',
            ],
            [
                'test_name' => 'ECG (Electrocardiogram)',
                'description' => 'Records electrical activity of the heart',
                'test_type' => 'imaging',
                'test_date' => Carbon::now(),
                'results_received_date' => null,
                'status' => 'pending',
                'result_value' => null,
                'unit' => null,
                'reference_range' => 'Normal sinus rhythm',
                'provider_notes' => 'Scheduled for routine screening. Awaiting test date confirmation.',
            ],
        ];

        foreach ($testData as $data) {
            LabResult::create([
                'user_id' => $user -> id,
                ...$data,
            ]);
        }
    }
}
