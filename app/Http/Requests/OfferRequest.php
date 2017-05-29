<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (\Auth::user()->hasRole("admin") || \Auth::user()->hasRole("owner"));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "percentage" => "required|min:1|max:100|integer",
            "start_date" => "required|date|after:today",
            "end_date" => "required|date|after:start_date",
        ];
    }

    public function messages() {
        return [
            "percentage.required" => "Percentage is required",
            "percentage.min" => "Percentage lies between 1 and 100",
            "percentage.max" => "Percentage lies between 1 and 100",
            "percentage.integer" => "Percentage is an integer",
            "start_date.requried" => "Start date is required",
            "start_date.date" => "The value you entered isn't a date",
            "start_date.after" => "Offer cannot start at the past",
            "end_date.required" => "End date is required",
            "end_date.date" => "The value you entered isn't a date",
            "end_date.after" => "End date cannot be before start date",
        ];
    }
}
