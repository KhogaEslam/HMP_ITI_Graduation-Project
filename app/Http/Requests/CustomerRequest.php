<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return \Auth::check() && (\Auth::user()->hasRole("customer"));
    }

    public function rules()
    {
        return [
            "name" => "required|min:2",
            "password" => "sometimes|nullable|min:6",
            "password_confirmation" => "same:password",
            "date_of_birth" => "required",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Name field is required",
            "name.min" => "At least 2 characters must be provided",
            "password.min" => "Password should be atleast 6 characters",
            "password_confirmation.same" => "Passwords doesn't match",
            "date_of_birth" => "Birth date field is required",
        ];
    }
}
