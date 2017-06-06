<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (\Auth::check() && (\Auth::user()->hasRole("admin")|| \Auth::user()->hasRole("owner")) );
    }
    public function rules()
    {
        return [
        ];
    }

}
