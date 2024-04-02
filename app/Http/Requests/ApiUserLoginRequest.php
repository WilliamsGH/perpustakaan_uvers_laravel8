<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\UserLoginRequest;

class ApiUserLoginRequest extends UserLoginRequest
{
    protected function failedValidation(Validator $validator)   
    {
        throw new HttpResponseException(response([
            'error' =>  [
                'category' => 'error_param',
                'message' => 'Invalid parameters provided, Please check your request and try again.',
                'detail' => $validator->getMessageBag(),
                ]
        ], 400));
    }
}
