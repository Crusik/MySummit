<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = $request -> user()
             -> payments()
             -> orderBy('created_at', 'desc')
             -> get();

        return response() -> json($payments);
    }

    public function store(Request $request)
    {
        $validated = $request -> validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'payment_method' => 'nullable|string'
        ]);

        $payment = Payment::create($validated);
        return response() -> json($payment, 201);
    }
}