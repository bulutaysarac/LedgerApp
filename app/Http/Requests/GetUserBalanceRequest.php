<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class GetUserBalanceRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'userId' => 'required|integer|exists:users,id',
        ];
    }

    /**
     * @param Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator): mixed
    {
        $errors = $validator->messages()->toArray();

        throw new HttpResponseException(
            response()->json(
                ['errors' => $errors, 'message' => 'Invalid payload!'],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            )
        );
    }
}
