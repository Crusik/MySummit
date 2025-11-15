<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run()
    {
        // Get Michael by ID
        $michael = \App\Models\User::find(1);

        if ($michael) {
            // Michael's events
            Event::create([
                'user_id' => $michael->id,
                'title' => 'Doctor Appointment',
                'description' => 'Routine check-up with Dr. Smith',
                'start_time' => Carbon::now()->addDays(2)->setTime(10, 0),
                'end_time' => Carbon::now()->addDays(2)->setTime(11, 0),
            ]);

            Event::create([
                'user_id' => $michael->id,
                'title' => 'Physical Therapy',
                'description' => 'Session with Nurse Taylor',
                'start_time' => Carbon::now()->addDays(3)->setTime(14, 0),
                'end_time' => Carbon::now()->addDays(3)->setTime(15, 0),
            ]);

            Event::create([
                'user_id' => $michael->id,
                'title' => 'Virtual Consultation',
                'description' => 'Online session with Dr. Smith',
                'start_time' => Carbon::now()->addDays(5)->setTime(9, 0),
                'end_time' => Carbon::now()->addDays(5)->setTime(9, 30),
            ]);
        }

        // Get Lisa by ID
        $lisa = \App\Models\User::find(5);

        if ($lisa) {
            // Lisa's events
            Event::create([
                'user_id' => $lisa->id,
                'title' => 'Team Meeting',
                'description' => 'Weekly clinical team meeting',
                'start_time' => Carbon::now()->addDays(1)->setTime(9, 0),
                'end_time' => Carbon::now()->addDays(1)->setTime(10, 0),
            ]);

            Event::create([
                'user_id' => $lisa->id,
                'title' => 'Patient Follow-up',
                'description' => 'Check-in call with patient',
                'start_time' => Carbon::now()->addDays(2)->setTime(14, 0),
                'end_time' => Carbon::now()->addDays(2)->setTime(14, 30),
            ]);

            Event::create([
                'user_id' => $lisa->id,
                'title' => 'Training Session',
                'description' => 'Professional development training',
                'start_time' => Carbon::now()->addDays(4)->setTime(11, 0),
                'end_time' => Carbon::now()->addDays(4)->setTime(12, 30),
            ]);
        }
    }
}