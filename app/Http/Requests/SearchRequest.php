<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {

        $this->sanitize();
        $rules =[
            'name' => 'sometimes|nullable|string',
            'price' => 'sometimes|nullable|integer',
            'rate' =>'sometimes|nullable|integer|min:1|max:5',
        ];
        if (!empty($this->request->get('cat_name'))) {
            foreach ($this->request->get('cat_name') as $a => $z) {
                $rules['cat_name.' . $a] = 'sometimes|nullable|string';
            }
        }
        return $rules;
    }

    public function sanitize()
    {
        $input = $this->all();
         if (isset($input['name'])) {
            $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
        }
        if (!empty($this->request->get('cat_name'))) {
            foreach ($this->request->get('cat_name') as $a=>$z) {
                $input['cat_name.' . $a] = filter_var($z, FILTER_SANITIZE_STRING);
            }
        }
        if (isset($input['price'])) {
            $input['price'] = filter_var($input['price'], FILTER_SANITIZE_NUMBER_INT);
        }
        if (isset($input['rate'])) {
            $input['rate'] = filter_var($input['rate'], FILTER_SANITIZE_NUMBER_INT);
        }
        $this->replace($input);
    }
}
