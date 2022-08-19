<?php

namespace App\Enums;

/**
 * Class MensagensEnum
 *
 * @package App\Enums
 */
class MensagensEnum
{
    const THROW_EXECEPTION = 'Sua solicitação não pode ser processada! Entre em contato com o administrador.';

    const NOT_ALLOWED = 'Você não tem as permissões necessárias para realizar a essa ação!';

    const CREATED_ITEM = 'Item criado com sucesso!';

    const UPDATED_ITEM = 'Item atualizado com sucesso!';

    const NOT_FOUND = 'O item que você solicitou não existe!';

    const DELETED_ITEM = 'O item foi apagado!';

    const NOT_ALLOWED_TO_DELETE = 'Este item não pode ser apagado!';

    const PROFILE_UPDATED = 'Perfil atualizado com sucesso!';

    const ADMIN_PWD_CHANGED = 'A senha foi alterada com sucesso!';

    const WRONG_PWD = 'A senha atual informada está incorreta!';

    const DISABLED_ACCOUNT = 'Sua conta está inativa, por favor entre em contato com o administrador';

    const USUARIO_NAO_ENCONTRADO = 'Os dados informados não correspondem a nenhum usuário!';

    const PROJETO_COM_SUCESSO = 'Projeto inserido com sucesso!';

    const PROJETO_EDIT_COM_SUCESSO = 'Status alterado com sucesso!';

    const PROJETO_EXCLUIR_COM_SUCESSO = 'Demanda excluida com sucesso!';

    const ITOP_ATT_COM_SUCESSO = 'Quantidade de ITOPs alterada com sucesso!';
}
