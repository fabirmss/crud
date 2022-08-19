<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acessos extends Model
{
    protected $table='acessos';

    protected $fillable = ["id","date","minutos","idcliente", "idcanal"];


    public function cliente(){
        return $this->belongsTo(Cliente::class, 'idcliente', 'id');
    }

    public function canal(){
        return $this->belongsTo(Canal::class, 'idcanal', 'id');
    }

}
