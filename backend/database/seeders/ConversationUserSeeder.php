<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conversation;
use App\Models\User;

class ConversationUserSeeder extends Seeder
    {
        public function run(): void
        {
            // Get the patient
            $patient = User::where('email', 'michael@example.com') -> first();

            // Get medical professionals
            $drSmith = User::where('email', 'dr.smith@example.com') -> first();
            $nurseTaylor = User::where('email', 'nurse.taylor@example.com') -> first();
            $drJohnson = User::where('email', 'dr.johnson@example.com') -> first();
            $nutritionist = User::where('email', 'lisa.chen@example.com') -> first();

            $conversations = Conversation::all();

            if (!$patient || $conversations -> isEmpty()) {
                return;
            }

            // Conversation 1: Patient + Dr. Smith
            if ($conversations -> count() > 0 && $drSmith) {
                $conversations[0] -> users() -> attach([$patient -> id, $drSmith -> id]);
            }

            // Conversation 2: Patient + Nurse Taylor
            if ($conversations -> count() > 1 && $nurseTaylor) {
                $conversations[1] -> users() -> attach([$patient -> id, $nurseTaylor -> id]);
            }

            // Conversation 3: Patient + Dr. Johnson
            if ($conversations -> count() > 2 && $drJohnson) {
                $conversations[2] -> users() -> attach([$patient -> id, $drJohnson -> id]);
            }

            // Conversation 4: Patient + Nutritionist
            if ($conversations -> count() > 3 && $nutritionist) {
                $conversations[3] -> users() -> attach([$patient -> id, $nutritionist -> id]);
            }
        }
    }