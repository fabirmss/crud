<?php

namespace App\Http\Requests\Admin\Permissoes;

use App\Entities\Permissao;
use App\Services\VerifyIdInUpdate;
use Illuminate\Foundation\Http\FormRequest;

class PermissoesRequest extends FormRequest
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
     * @param Permissao $permissao
     *
     * @return array
     */
    public function rules(Permissao $permissao)
    {
        $itemId = VerifyIdInUpdate::getUpdateItemId($this, $permissao, $this->permisso);

        return [
            'nome' => 'required|unique:permissoes,nome,' . $itemId
        ];
    }
}
