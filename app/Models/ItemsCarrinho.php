<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsCarrinho extends Model
{
    use HasFactory;

    public function produto()
    {
        return $this->belongsTo(Produtos::class);
    }
    protected $fillable = [
        'produto_id',
        'carrinho_id',
        'quantidade',
        'valor_final_produto',
    ];
    protected $nullabel = [];

    public static function getRegras()
    {
        $regras = [
            'produto_id' => 'required',
            'carrinho_id' => 'required',
            'quantidade' => 'required',
            'valor_final_produto' => 'required',

        ];

        return $regras;
    }

    public static function getMensagens()
    {
        $menssagens = [
            'produto_id.required' => 'Campo obrigatório!',
            'carrinho_id.required' => 'Campo obrigatório!',
            'quantidade.required' => 'Campo obrigatório!',
            'valor_final_produto.required' => 'Campo obrigatório!',
        ];


        return $menssagens;
    }


}
