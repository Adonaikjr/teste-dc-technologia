<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Clientes extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nome',
        'cpf',
    ];
    protected $nullabel = [];
    public static function getRegras()
    {
        $regras = [
            'nome' => 'required',
            'user_id' => 'required',
            'cpf' => 'required',
        ];

        return $regras;
    }

    public static function getMensagens()
    {
        $menssagens = [
            'user_id.required' => 'Campo obrigatório!',
            'nome.required' => 'Campo obrigatório!',
            'cpf.required' => 'Campo obrigatório!',
        ];


        return $menssagens;
    }



}
