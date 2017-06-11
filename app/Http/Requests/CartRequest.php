<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (\Auth::check() && \Auth::user()->hasRole("customer")) || \Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "quantity" => "required|integer|min:1",
        ];
    }

    public function messages() {
        return [
            "quantity.required" => "This field is required",
            "quantity.integer" => "Quantity must be an integer",
            "quantity.min" => "Minimum value for quantity is 1",
        ];
    }
}
