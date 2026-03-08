<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutOrderRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            'comment' => 'nullable|max:255',
        ];
    }
}
