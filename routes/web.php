<?php


Route::get('/', 'HomeController\HomeController@home');

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function () {
    Route::get('/dashboard', 'Dashboard\DashboardController@dashboard')->name('admin.home');

    Route::put('update/pwd/{hash}', 'Usuarios\UsuariosController@updatePwd')->name('admin.user.pwd');

    Route::resource(
        'usuarios',
        'Usuarios\UsuariosController',
        [
            'as' => 'admin',
        ]
    )->except(['show']);

    Route::resource(
        'papeis',
        'Papeis\PapeisController',
        [
            'as' => 'admin',
        ]
    )->except(['show']);

    Route::resource(
        'permissoes',
        'Permissoes\PermissoesController',
        [
            'as' => 'admin',
        ]
    )->except(['show']);
});



Route::group([
    'middleware' => ['auth'],
    'prefix' => 'escala',
    'namespace' => 'Ranking',
], function () {

    Route::get('cadastrar-acesso', 'AcessosController@create')->name('escala.cadastrar-acessos.show');
    Route::post('cadastrar-acesso', 'AcessosController@store')->name('escala.cadastrar-acessos.store');


    Route::get('cadastrar-canal', 'CanalController@create')->name('escala.cadastrar-canal.show');
    Route::post('cadastrar-canal', 'CanalController@store')->name('escala.cadastrar-canal.store');

    Route::get('editar-canal/{id}', 'CanalController@edit')->name('escala.editar-canal.edit');

    Route::put('update-canal/{id}', 'CanalController@update')->name('escala.update-canal.update');

    Route::get('deletar-canal/{id}', 'CanalController@destroy')->name('escala.deletar-canal.destroy');


    Route::get('cadastrar-cliente', 'ClienteController@create')->name('escala.cadastrar-cliente.show');
    Route::post('cadastrar-cliente', 'ClienteController@store')->name('escala.cadastrar-cliente.store');

    Route::get('editar-cliente/{id}', 'ClienteController@edit')->name('escala.editar-cliente.edit');

    Route::put('update-cliente/{id}', 'ClienteController@update')->name('escala.update-cliente.update');

    Route::get('deletar-cliente/{id}', 'ClienteController@destroy')->name('escala.deletar-cliente.destroy');



});

Route::get('gerenciar-cadastros', 'Ranking\GerenciarCadastroController@gerenciarCadastros')->name('escala.gerenciar.cadastros');
Route::get('gerenciar', 'Ranking\GerenciarController@gerenciar')->name('escala.gerenciar');

Auth::routes();
