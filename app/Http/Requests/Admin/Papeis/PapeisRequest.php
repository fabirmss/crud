<?php

namespace App\Http\Requests\Admin\Papeis;

use App\Entities\Papel;
use App\Services\VerifyIdInUpdate;
use Illuminate\Foundation\Http\FormRequest;

class PapeisRequest extends FormRequest
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
     * @param Papel $papel
     *
     * @return array
     */
    public function rules(Papel $papel)
    {
        $itemId = VerifyIdInUpdate::getUpdateItemId($this, $papel, $this->papei);

        return [
            'nome' => 'required|unique:papeis,nome,' . $itemId,
            'permissoes' => 'required',
        ];
    }
}
