<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ControllerClientes extends Controller
{
    private function validarCampos($dados, $model)
    {
        $validador = Validator::make($dados, $model::getRegras(), $model::getMensagens());

        if ($validador->fails()) {
            Session::flash('erro', 'Ooops algo deu errado...!');
            return redirect()->back()->withErrors($validador->errors())->withInput($dados);
        }
    }

    public function create(Request $req)
    {
        try {
            $data = $req->only(['nome', 'cpf']);

            $data['user_id'] = Auth::id();

            $model = new Clientes;

            $checkValidacao = $this->validarCampos($data, $model);

            if ($checkValidacao instanceof RedirectResponse) {
                return $checkValidacao;
            }

            $cliente = Clientes::create($data);

            Session::flash('sucesso', 'Cliente Cadastrado');
            return redirect()->route('vendas');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function buscar(Request $request)
    {
        $query = $request->input('query');
        $clientes = Clientes::where('nome', 'LIKE', "%{$query}%")->get();
        return response()->json($clientes);
    }

}
