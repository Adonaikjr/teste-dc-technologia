<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Pagamento;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrinho;
use App\Models\ItemsCarrinho;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ControllerVendas
{
    public function index()
    {

        $clientes = Clientes::all();
        return view('Vendas.index', compact('clientes'));
    }
    public function criar(Request $req)
    {

        $data = $req->only(['cliente_id', 'itens_carrinho', 'parcelas', 'valor_total']);

        $CriarCarrinho = function ($cliente_id) {
            $carrinho_id = new Carrinho();
            $carrinho_id['user_id'] = Auth::id();
            $carrinho_id['cliente_id'] = $cliente_id;
            $carrinho_id->save();
            $id = $carrinho_id;

            return $id;
        };

        $CriarItem = function ($produto_id, $carrinho_id, $quantidade, $valor_final_produto) {
            $item_carrinho = new ItemsCarrinho();
            $item_carrinho['produto_id'] = $produto_id;
            $item_carrinho['carrinho_id'] = $carrinho_id;
            $item_carrinho['quantidade'] = $quantidade;
            $item_carrinho['valor_final_produto'] = $valor_final_produto;
            return $item_carrinho->save();
        };

        $carrinhoId = $CriarCarrinho($data['cliente_id'])->id;
        $itemsCarrinho = $data['itens_carrinho'];

        foreach ($itemsCarrinho as $item) {
            $produto_id = $item['produto_id'];
            $carrinho_id = $carrinhoId;
            $quantidade = $item['quantidade'];
            $valor_final_produto = $item['sub_total'];

            $CriarItem($produto_id, $carrinho_id, $quantidade, $valor_final_produto);
        }

        $CriarVenda = function ($carrinho_id, $clienteId, $valor_total) {
            $Venda = new Venda();
            $Venda['user_id'] = Auth::id();
            $Venda['carrinho_id'] = $carrinho_id;
            $Venda['cliente_id'] = $clienteId;
            $Venda['valor_total'] = $valor_total;
            $Venda->save();
            $venda_id = $Venda->id;
            return $venda_id;
        };


        $clienteId = $data['cliente_id'];
        $valorTotal = $data['valor_total'];
        $vendaId = $CriarVenda($carrinhoId, $clienteId, $valorTotal);

        $CriarPagamento = function ($carrinho_id, $clienteId, $venda_id, $valor, $parc) {
            $Pagamento = new Pagamento();
            $Pagamento['user_id'] = Auth::id();
            $Pagamento['carrinho_id'] = $carrinho_id;
            $Pagamento['cliente_id'] = $clienteId;
            $Pagamento['venda_id'] = $venda_id;
            $Pagamento['valor'] = $valor;
            $Pagamento['venc_parcela'] = $parc;

            return $Pagamento->save();
        };

        $VencParcelas = $data['parcelas'];

        foreach ($VencParcelas as $item) {
            $valor = $item['valor'];
            $venc_parc = Carbon::createFromFormat('d/m/Y', $item['data']);
            $CriarPagamento($carrinhoId, $clienteId, $vendaId, $valor, $venc_parc);
        }

        Session::flash('sucesso', 'Venda realizada!');
        return response()->json($vendaId);
    }


    public function lista()
    {
        $vendas = Venda::all();

        return view('Vendas.lista', compact('vendas'));
    }
    public function dadosVenda(Request $req, $vendaId)
    {
        $venda = Venda::where('id', $vendaId)->first();

        $carrinhoItems = ItemsCarrinho::where('carrinho_id', $venda->carrinho_id)->get();

        $pagamento = Pagamento::where('carrinho_id', $venda->carrinho_id);


        return view('Vendas.update', compact('carrinhoItems', 'venda', 'pagamento'));
    }

    public function buscar(Request $req)
    {
        try {
            $query = $req->input('query');
            $produto = Clientes::where('nome', 'LIKE', "%{$query}%")->get();

            return response()->json($produto);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function deletar($vendaId)
    {
        $venda = Venda::find($vendaId);
        $venda->delete();
        Session::flash('sucesso', 'Venda Deletada!');
        return redirect()->back()->route('lista-venda');
    }

}
