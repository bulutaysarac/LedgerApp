<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferCreditsRequest extends FormRequest
{
    /**
     * @return true
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'recipient_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01'
        ];
    }
}
