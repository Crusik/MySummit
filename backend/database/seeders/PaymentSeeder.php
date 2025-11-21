<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        // Get Michael by ID
        $michael = \App\Models\User::find(1);

        if ($michael) {
            // Michael's payments
            Payment::create([
                'user_id' => $michael -> id,
                'amount' => 50.00,
                'status' => 'completed',
                'description' => 'Office visit - Cardiology consultation',
                'payment_method' => 'card',
                'paid_at' => Carbon::now() -> subDays(5),
            ]);

            Payment::create([
                'user_id' => $michael -> id,
                'amount' => 25.00,
                'status' => 'completed',
                'description' => 'Lab work - Blood panel',
                'payment_method' => 'card',
                'paid_at' => Carbon::now() -> subDays(3),
            ]);

            Payment::create([
                'user_id' => $michael -> id,
                'amount' => 75.00,
                'status' => 'pending',
                'description' => 'Prescription refills - Monthly maintenance',
                'payment_method' => 'card',
                'paid_at' => null,
            ]);

            Payment::create([
                'user_id' => $michael -> id,
                'amount' => 100.00,
                'status' => 'completed',
                'description' => 'Annual physical examination',
                'payment_method' => 'card',
                'paid_at' => Carbon::now() -> subDays(1),
            ]);
        }

        // Get Lisa by ID
        $lisa = \App\Models\User::find(5);

        if ($lisa) {
            // Lisa's payments
            Payment::create([
                'user_id' => $lisa -> id,
                'amount' => 100.00,
                'status' => 'completed',
                'description' => 'Annual physical examination',
                'payment_method' => 'bank_transfer',
                'paid_at' => Carbon::now() -> subDays(7),
            ]);

            Payment::create([
                'user_id' => $lisa -> id,
                'amount' => 150.00,
                'status' => 'completed',
                'description' => 'Specialist consultation - Orthopedics',
                'payment_method' => 'card',
                'paid_at' => Carbon::now() -> subDays(2),
            ]);

            Payment::create([
                'user_id' => $lisa -> id,
                'amount' => 60.00,
                'status' => 'pending',
                'description' => 'Imaging services - X-ray',
                'payment_method' => 'card',
                'paid_at' => null,
            ]);
        }
    }
}
