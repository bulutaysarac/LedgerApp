<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetBalanceAtTimeRequest extends FormRequest
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
            'time' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
