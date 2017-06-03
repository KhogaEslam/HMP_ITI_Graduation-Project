<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;

class BannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (\Auth::user()->hasRole("shop"));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->rules;

        if (Input::get('type') == 0 )
        {
            $rules['product'] = 'required';
        }
        $rules["start_date"] = "required|date|after:today";
        $rules["end_date"] = "required|date|after:start_date";
        $rules["image"] = "required|image";
        return $rules;
    }

    public function messages() {
        return [
            "start_date.required" => "Start date is required",
            "start_date.date" => "The value you entered isn't a date",
            "start_date.after" => "Banner request cannot start at the past",
            "end_date.required" => "End date is required",
            "end_date.date" => "The value you entered isn't a date",
            "end_date.after" => "End date cannot be before start date",
            "image.required" => "Image is required",
            "image.image" => "Uploaded file must be an image",
        ];
    }
}
