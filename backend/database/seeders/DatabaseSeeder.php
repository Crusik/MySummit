<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this -> call([
            UserSeeder::class,
            ConversationSeeder::class,
            ConversationUserSeeder::class,
            MessageSeeder::class,
            PaymentSeeder::class,
            EventSeeder::class,
            HealthRecordSeeder::class,
            LabResultSeeder::class,
        ]);
    }
}
