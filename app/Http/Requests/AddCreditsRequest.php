<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCreditsRequest extends FormRequest
{
    /**
     * @return mixed
     */
    public function authorize(): mixed
    {
        return auth()->user()->tokenCan('admin');
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ];
    }
}
