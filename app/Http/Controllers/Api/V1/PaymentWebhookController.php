<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Payments\PaymentService;
use Illuminate\Http\Request;

class PaymentWebhookController extends Controller
{
    public function __construct(private readonly PaymentService $paymentService) {}

    public function handle(Request $request, string $provider)
    {
        $payment = $this->paymentService->handleWebhook(
            $provider,
            $this->normalizeHeaders($request),
            $request->all()
        );

        return response()->json([
            'data' => [
                'payment_id' => $payment->public_id,
                'status' => $payment->status,
            ],
        ]);
    }

    private function normalizeHeaders(Request $request): array
    {
        $headers = [];

        foreach ($request->headers->all() as $key => $values) {
            $headers[strtolower($key)] = is_array($values) ? (string) ($values[0] ?? '') : (string) $values;
        }

        return $headers;
    }
}
