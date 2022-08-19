<?php

namespace App\Providers;

use App\Entities\Permissao;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $permissions = $this->listPermissions();

        if (!empty($permissions)) {
            foreach ($permissions as $permission) {
                // Define todas permissões que existe com base no que está
                // cadastrado no banco de dados
                Gate::define($permission->slug, function ($user) use ($permission) {
                    // retorna true ou false dependendo se o usuário tem a permissão
                    // ou caso o usuário seja um super admin
                    return $user->hasRole($permission->slug) || $user->isSuperAdmin();
                });
            }
        }
    }

    /**
     * Busca todas as permissões cadastradas no sistema
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function listPermissions()
    {
        /**
         * Esta verificação é preciso para evitar erros no migration
         * Se não for verificado, é retornado um erro informando que
         * a tabela não pode ser encontrada
         *
         * É preciso encontrar o motivo do erro para
         * evitar consultas desnecessárias ao banco de dados
         */
        if (!Schema::hasTable('permissoes')) {
            return [];
        }

        return Permissao::with('papeis')->get();
    }
}
