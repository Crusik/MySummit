<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\User;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        // Delete old messages
        Message::query() -> delete();

        $patient = User::where('email', 'michael@example.com') -> first();
        $drSmith = User::where('email', 'dr.smith@example.com') -> first();
        $nurseTaylor = User::where('email', 'nurse.taylor@example.com') -> first();
        $drJohnson = User::where('email', 'dr.johnson@example.com') -> first();
        $nutritionist = User::where('email', 'lisa.chen@example.com') -> first();

        $conversations = Conversation::all();

        if ($conversations -> isEmpty() || !$patient) {
            return;
        }

        // Messages for Conversation 1: Dr. Smith
        if ($conversations -> count() > 0 && $drSmith) {
            Message::create([
                'conversation_id' => $conversations[0] -> id,
                'sender_id' => $drSmith -> id,
                'text' => 'Hello, this is Dr. Smith. How are you feeling today?',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[0] -> id,
                'sender_id' => $patient -> id,
                'text' => 'Hi Dr. Smith, I\'ve been feeling better, thank you for asking.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[0] -> id,
                'sender_id' => $drSmith -> id,
                'text' => 'That\'s great to hear. Your latest lab results look good. Let\'s schedule a follow-up next week.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[0] -> id,
                'sender_id' => $patient -> id,
                'text' => 'Sounds good. What time works best for you?',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[0] -> id,
                'sender_id' => $drSmith -> id,
                'text' => 'How about Tuesday at 10 AM?',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[0] -> id,
                'sender_id' => $patient -> id,
                'text' => 'Perfect! I\'ll put that on my calendar.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[0] -> id,
                'sender_id' => $drSmith -> id,
                'text' => 'Great! Also, I wanted to discuss your blood pressure readings. They\'ve been consistently normal, which is excellent.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[0] -> id,
                'sender_id' => $patient -> id,
                'text' => 'That\'s wonderful! I\'ve been trying to maintain a healthy lifestyle.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[0] -> id,
                'sender_id' => $drSmith -> id,
                'text' => 'Keep it up! Your commitment to your health is really paying off.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[0] -> id,
                'sender_id' => $patient -> id,
                'text' => 'Thank you! I appreciate your guidance and support throughout this journey.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[0] -> id,
                'sender_id' => $drSmith -> id,
                'text' => 'You\'re very welcome. That\'s what I\'m here for. See you next Tuesday!',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[0] -> id,
                'sender_id' => $patient -> id,
                'text' => 'Looking forward to it. Have a great day!',
                'is_read' => false,
            ]);
        }

        // Messages for Conversation 2: Nurse Taylor
        if ($conversations -> count() > 1 && $nurseTaylor) {
            Message::create([
                'conversation_id' => $conversations[1] -> id,
                'sender_id' => $nurseTaylor -> id,
                'text' => 'Hi there! Just checking in to confirm your next appointment.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[1] -> id,
                'sender_id' => $patient -> id,
                'text' => 'Yes, I\'m planning to come in next Tuesday at 2 PM.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[1] -> id,
                'sender_id' => $nurseTaylor -> id,
                'text' => 'Perfect! Please remember to bring your insurance card and any medications you\'re currently taking.',
                'is_read' => false,
            ]);
        }

        // Messages for Conversation 3: Dr. Johnson
        if ($conversations->count() > 2 && $drJohnson) {
            Message::create([
                'conversation_id' => $conversations[2] -> id,
                'sender_id' => $drJohnson -> id,
                'text' => 'Hi Michael, I wanted to discuss your recent test results with you.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[2] -> id,
                'sender_id' => $patient -> id,
                'text' => 'Of course, I\'ve been waiting to hear about them. What did you find?',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[2] -> id,
                'sender_id' => $drJohnson -> id,
                'text' => 'Everything looks normal. I\'d recommend continuing with your current treatment plan.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[2] -> id,
                'sender_id' => $patient -> id,
                'text' => 'That\'s wonderful news! Thank you, Dr. Johnson.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[2] -> id,
                'sender_id' => $drJohnson -> id,
                'text' => 'You\'re welcome. See you at your next appointment!',
                'is_read' => false,
            ]);
        }

        // Messages for Conversation 4: Nutritionist
        if ($conversations->count() > 3 && $nutritionist) {
            Message::create([
                'conversation_id' => $conversations[3] -> id,
                'sender_id' => $nutritionist -> id,
                'text' => 'Hi Michael! I\'ve prepared a personalized nutrition plan for you based on your health goals.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[3] -> id,
                'sender_id' => $patient -> id,
                'text' => 'That sounds great! I\'m ready to make some lifestyle changes.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[3] -> id,
                'sender_id' => $nutritionist -> id,
                'text' => 'Excellent! I\'m sending you the plan via email. Let\'s schedule a consultation to go over the details.',
                'is_read' => true,
            ]);

            Message::create([
                'conversation_id' => $conversations[3] -> id,
                'sender_id' => $patient -> id,
                'text' => 'Perfect! What time works best for you?',
                'is_read' => false,
            ]);
        }
    }
}
