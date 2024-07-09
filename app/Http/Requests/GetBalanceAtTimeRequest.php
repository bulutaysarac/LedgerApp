<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetBalanceAtTimeRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->tokenCan('admin'); // Ensure the user has admin scope
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'time' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
