<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferCreditsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'recipient_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01'
        ];
    }
}
