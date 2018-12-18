<?php

namespace Requests;

use Requests\Request;

class LoginRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function __construct(){
        $this->authenticatable = false;
    }

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
        'email' => 'required|email',
        'password' => 'required',
            
        ];
    }
}
