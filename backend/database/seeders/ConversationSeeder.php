<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conversation;

class ConversationSeeder extends Seeder
{
    public function run(): void
    {
        // Delete old conversations
        Conversation::query()->delete();

        // Create conversations with different medical professionals
        Conversation::create([]);
        Conversation::create([]);
        Conversation::create([]);
        Conversation::create([]);
    }
}
