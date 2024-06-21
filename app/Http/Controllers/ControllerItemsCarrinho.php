<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use App\Models\ItemsCarrinho;
use App\Models\Produtos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;


class ControllerItemsCarrinho extends Controller
{

    private function validarCampos($dados, $model)
    {
        $validador = Validator::make($dados, $model::getRegras(), $model::getMensagens());

        if ($validador->fails()) {
            Session::flash('erro', 'Verifique o formulário para entender o motivo!');
            return redirect()->back()->withErrors($validador->errors())->withInput($dados);
        }
    }

    public function criarCarrinho(Request $req)
    {
        try {
            $data = $req->only(['produto_id', 'quantidade', 'sub_total', 'cliente_id']);

            $CriarCarrinho = function ($cliente_id) {
                $carrinho_id = new Carrinho();
                $carrinho_id['user_id'] = Auth::id();
                $carrinho_id['cliente_id'] = $cliente_id;
                $carrinho_id->save();
                $id = $carrinho_id;

                return $id;
            };

            $cliente_id = $data['cliente_id'];
            $produto_id = $data['produto_id'];
            $carrinho_id = $CriarCarrinho($cliente_id);

            $Item = [
                'produto_id' => $produto_id,
                'quantidade' => $data['quantidade'],
                'carrinho_id' => $carrinho_id->id,
                'valor_final_produto' =>  number_format($data['sub_total'], 2, '.', ''),
            ];

            $model = new ItemsCarrinho;

            $checkValidacao = $this->validarCampos($Item, $model);
            if ($checkValidacao instanceof RedirectResponse) {
                return $checkValidacao;
            }

            $adicionarItem = fn() => ItemsCarrinho::create($Item);
            $Item = $adicionarItem();

            $titulo_produto = Produtos::find($Item->produto_id);


             $res = [
                'id' => $Item->id,
                'produto' => $titulo_produto->titulo,
                'produto_id' => $Item->produto_id,
                'quantidade' => $Item->quantidade,
                'carrinho_id' => $Item->carrinho_id,
                'valor_final_produto' => $Item->valor_final_produto,
             ];

            return response()->json($res, 201);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
