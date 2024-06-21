<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    use HasFactory;

    public function itens()
    {
        return $this->hasMany(ItemsCarrinho::class);
    }

    protected $fillable = [
        'user_id',
        'cliente_id',
    ];
    protected $nullabel = [];

    public static function getRegras()
    {
        $regras = [
            'user_id' => 'required',
            'cliente_id' => 'required',
        ];

        return $regras;
    }

    public static function getMensagens()
    {
        $menssagens = [
            'user_id.required' => 'Campo obrigatório!',
            'cliente_id.required' => 'Campo obrigatório!',
        ];


        return $menssagens;
    }
}
