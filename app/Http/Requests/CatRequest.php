<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ((\Auth::check() && (\Auth::user()->hasRole("admin"))) || (\Auth::check() && (\Auth::user()->hasRole("owner"))));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        $this->sanitize();
        return [
            'name' => 'required|unique:categories|min:2|max:50|string'
        ];
    }

    public function sanitize()
    {
        $input = $this->all();
        if (isset($input['name']))
        {
            $input['name'] = filter_var($input['name'] , FILTER_SANITIZE_STRING);
        }
        $this->replace($input);
    }
}
