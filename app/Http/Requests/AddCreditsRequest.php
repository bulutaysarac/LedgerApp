<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCreditsRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->tokenCan('admin'); // Ensure the user has admin scope
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ];
    }
}
