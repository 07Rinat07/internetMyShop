<?php

namespace App\Http\Controllers;

use App\Models\Payment;

class PaymentStatusController extends Controller
{
    public function show(Payment $payment)
    {
        return view('payments.show', [
            'payment' => $payment->load('order.items'),
        ]);
    }
}
