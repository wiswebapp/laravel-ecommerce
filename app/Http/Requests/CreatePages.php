<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePages extends FormRequest
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
        return [
            'page_title' => 'required',
            'page_description' => 'required',
            'page_meta_keyword' => 'required',
            'page_meta_description' => 'required',
            'status' => 'required',
        ];
    }
}
