<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;
    public function carrinho()
    {
        return $this->belongsTo(Carrinho::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class);
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }

    public function itens()
    {
        return $this->hasManyThrough(ItemsCarrinho::class, Carrinho::class, 'id', 'carrinho_id', 'carrinho_id', 'id');
    }

    protected $fillable = [
        'user_id',
        'carrinho_id',
        'cliente_id',
        'valor_total',
    ];
}
