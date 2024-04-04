<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nik' => 'required',
            'password' => 'required'
        ];
    }

    public function getCredentials()
    {
        $nik = $this->get('nik');
        if($this->isEmail($nik)){
            return [
                'nik' => $nik,
                'password' => $this->get('password')
            ];
        }

        return $this->only('nik', 'password');
    }

    public function isEmail($param)
    {
        $factory = $this->container->make(ValidationFactory::class);

        return ! $factory->make(
            ['nik' => $param],
            ['nik' => 'nik']
        )->fails();
    }
}
