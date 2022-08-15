<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $fillable = ['nome', 'sobrenome', 'user_id'];

    public function telefones(){
        return $this->hasMany('App\Telefone');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
