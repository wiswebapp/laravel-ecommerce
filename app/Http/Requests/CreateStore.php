<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateStore extends FormRequest
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
        $method = $this->method();

        $rules = [
            'owner' => 'required|max:255|regex:/^[\pL\s\-]+$/u',
            'name' => 'required|max:255|regex:/^[\pL\s\-]+$/u',
            'location' => 'required|max:500',
            'address' => 'required|max:500',
            'country' => 'required',
            'state' => 'required',
            'zipcode' => 'required',
            'status' => 'required',
        ];

        if($method == "POST") {
            $rules += [
                'email' => ['required', Rule::unique('stores', 'email'), 'email:rfc'],
                'password' => 'required|min:6',
            ];
        } else {
            $rules += [
                'email' => ['required', Rule::unique('admin', 'email')->ignore($this->route('id')), 'email:rfc'],
                'password' => 'nullable|min:6',
            ];
        }

        return $rules;
    }
}
