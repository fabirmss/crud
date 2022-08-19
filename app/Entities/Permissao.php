<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Permissao
 *
 * @package App\Entities
 */
class Permissao extends Model
{
    /**
     * Seta a conexão padrão do banco de dados
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * Configura o nome da tabela do banco de dados
     *
     * @var string
     */
    protected $table = 'permissoes';

    /**
     * Informa todos os campos que podem ser salvos no
     * mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'nome',
        'hash',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Configura o relacionamento com os papéis
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function papeis()
    {
        // Quando o relaciomanto é muito para muitos, a função chamada é
        // a belognsToMany e o segundo parâmetro é a pivot table
        return $this->belongsToMany(Papel::class, 'papel_permissao');
    }

    /**
     * Sobreescreve o método create para evitar ter que
     * adicionar campos vazios no formulário
     *
     * @param array $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        $attributes['hash'] = md5(uniqid(mt_rand(), true));
        $attributes['slug'] = Str::slug($attributes['nome'], '-');

        $model = new static($attributes);

        $model->save();

        return $model;
    }
}
