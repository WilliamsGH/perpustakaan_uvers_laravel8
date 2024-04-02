<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteWishListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'wishlist_id'  =>  ['required', 'exists:wish_lists,id'],
        ];
    }

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
