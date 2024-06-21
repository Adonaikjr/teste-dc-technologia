<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Produtos extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titulo',
        'preco',
        'user_id',
    ];
    protected $nullabel = [];

    public static function getRegras()
    {
        $regras = [
            'titulo' => 'required',
            'user_id' => 'required',
            'preco' => 'required',
        ];

        return $regras;
    }

    public static function getMensagens()
    {
        $menssagens = [
            'titulo.required' => 'Campo obrigatório!',
            'user_id.required' => 'Campo obrigatório!',
            'preco.required' => 'Campo obrigatório!',
        ];


        return $menssagens;
    }


}
