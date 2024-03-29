<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
        $id = !empty($this->route('id')) ? $this->route('id') : 0;

        $validatArr =  [
            'fname' => 'required|max:255|regex:/^[\pL\s\-]+$/u',
            'lname' => 'required|max:255|regex:/^[\pL\s\-]+$/u',
            'email' => [
                'required', Rule::unique('users', 'email')->ignore($id), 'email:rfc'
            ],
            'phone' => 'required|digits_between:10,15|integer',
            'status' => 'required',
            'country' => 'required',
            'state' => 'required',
        ];

        if(empty($id)){
            $validatArr['password'] = 'required|min:5|max:12';
        }

        return $validatArr;
    }
}
