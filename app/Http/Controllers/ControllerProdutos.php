<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;
class ControllerProdutos extends Controller
{

    private function validarCampos($dados, $model)
    {
        $validador = Validator::make($dados, $model::getRegras(), $model::getMensagens());

        if ($validador->fails()) {
            Session::flash('erro', 'Verifique o formulário para entender o motivo!');
            return redirect()->back()->withErrors($validador->errors())->withInput($dados);
        }
    }


    public function criar(Request $req)
    {
        try {
            $data = $req->only(['titulo', 'preco']);

            $data['preco'] = number_format($data['preco'], 2, '.', '');
            $data['user_id'] = Auth::id();


            $model = new Produtos;

            $checkValidacao = $this->validarCampos($data, $model);

            if ($checkValidacao instanceof RedirectResponse) {
                return $checkValidacao;
            }

            $User = Produtos::create($data);
            Session::flash('sucesso', 'Produto Cadastrado!');
            return response()->json(['message' => 'Produto criado com sucesso'], 201);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function buscar(Request $req)
    {
        try {
            $query = $req->input('query');
            $produto = Produtos::where('titulo', 'LIKE', "%{$query}%")->get();

            return response()->json($produto);
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
