<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'payment_method' => $this->input('payment_method', PaymentMethod::ManagerConfirmation->value),
        ]);
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            'comment' => 'nullable|max:255',
            'payment_method' => ['required', 'string', Rule::in(PaymentMethod::values())],
        ];
    }
}
