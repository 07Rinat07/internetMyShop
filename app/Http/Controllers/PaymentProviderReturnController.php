<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\Payments\PaymentService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PaymentProviderReturnController extends Controller
{
    public function __construct(private readonly PaymentService $paymentService)
    {
    }

    public function handleReturn(Request $request, string $provider, Payment $payment)
    {
        abort_unless($payment->provider === $provider, Response::HTTP_NOT_FOUND);

        try {
            $this->paymentService->finalize($payment, [
                'token' => $request->query('token'),
                'payer_id' => $request->query('PayerID'),
            ]);
        } catch (Throwable) {
            // The payment record is already marked as failed in the service. Redirect to status UI.
        }

        return redirect()->away($this->paymentService->statusPageUrl($payment));
    }

    public function handleCancel(string $provider, Payment $payment)
    {
        abort_unless($payment->provider === $provider, Response::HTTP_NOT_FOUND);

        if ($payment->statusEnum()->value !== 'succeeded') {
            $this->paymentService->markCancelled($payment, 'Payment was cancelled by the user.');
        }

        return redirect()->away($this->paymentService->statusPageUrl($payment));
    }
}
