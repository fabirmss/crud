<?php

namespace App\Http\Requests\Admin\User;

use App\Services\VerifyIdInUpdate;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @param User $usuario
     *
     * @return array
     */
    public function rules(User $usuario)
    {
        $itemId = VerifyIdInUpdate::getUpdateItemId($this, $usuario, $this->usuario);

        return [
            'email' => 'required|email|unique:users,email,' . $itemId,
            'name'  => 'required',
            'password' => 'min:6|confirmed',
            'password_confirmation' => 'min:6',
            'papel_id' => 'exists:papeis,id'
        ];
    }
}
