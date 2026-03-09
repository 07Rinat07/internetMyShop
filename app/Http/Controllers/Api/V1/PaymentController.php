<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\PaymentResource;
use App\Models\Payment;
use App\Services\Payments\PaymentService;
use Illuminate\Http\Request;
use Throwable;

class PaymentController extends Controller
{
    public function __construct(private readonly PaymentService $paymentService) {}

    public function show(Payment $payment)
    {
        return response()->json([
            'data' => (new PaymentResource($payment->load('order.items')))->resolve(),
        ]);
    }

    public function checkoutConfig(Payment $payment)
    {
        return response()->json([
            'data' => array_merge(
                $this->paymentService->checkoutConfiguration($payment),
                [
                    'payment_id' => $payment->public_id,
                    'status_url' => $this->paymentService->statusPageUrl($payment),
                ],
            ),
        ]);
    }

    public function capture(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'provider_payment_id' => 'nullable|string|max:255',
            'payer_id' => 'nullable|string|max:255',
        ]);

        try {
            $payment = $this->paymentService->finalize($payment, [
                'provider_payment_id' => $validated['provider_payment_id'] ?? null,
                'token' => $validated['provider_payment_id'] ?? null,
                'payer_id' => $validated['payer_id'] ?? null,
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Failed to capture payment.',
                'errors' => [
                    'payment' => [$exception->getMessage()],
                ],
            ], 422);
        }

        return response()->json([
            'data' => (new PaymentResource($payment->load('order.items')))->resolve(),
        ]);
    }
}
