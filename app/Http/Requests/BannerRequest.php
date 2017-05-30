<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (\Auth::user()->hasRole("vendor"));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "start_date" => "required|date|after:today",
            "end_date" => "required|date|after:start_date",
        ];
    }

    public function messages() {
        return [
            "start_date.required" => "Start date is required",
            "start_date.date" => "The value you entered isn't a date",
            "start_date.after" => "Offer cannot start at the past",
            "end_date.required" => "End date is required",
            "end_date.date" => "The value you entered isn't a date",
            "end_date.after" => "End date cannot be before start date",
        ];
    }
}
