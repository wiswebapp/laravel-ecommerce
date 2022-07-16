<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProduct extends FormRequest
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
            'category_id' => 'required|integer',
            'subcategory_id' => 'required|integer',
            'product_name' => 'required|max:255',
            'product_short_description' => 'required',
            'product_long_description' => 'required',
            'price' => 'required|integer',
            'is_available' => 'required',
            'status' => 'required',
        ];
    }
}
