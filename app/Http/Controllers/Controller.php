<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private function validarCampos($dados, $model)
    {
        $validador = Validator::make($dados, $model::getRegras(), $model::getMensagens());

        if ($validador->fails()) {
            Session::flash('erro', 'Verifique o formulário para entender o motivo!');
            return redirect()->back()->withErrors($validador->errors())->withInput($dados);
        }
    }

    //PAGE
    public function index()
    {
        return view('user.criar-user');
    }

    public function criar(Request $req)
    {
        try {
            $data = $req->only(['email', 'name', 'password']);

            $model = new User;

            $checkValidacao = $this->validarCampos($data, $model);

            if ($checkValidacao instanceof RedirectResponse) {
                return $checkValidacao;
            }

            $User = User::create($data);
            return redirect()->route('login');
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function login()
    {
        return view('user.login');
    }

    //AUTENCIAÇÃO DO USUARIO
    public function autenticarLogin(Request $request)
    {
        $credenciais = $request->only('email', 'password');

        $model = new User;
        $checkValidacao = $this->validarCampos($credenciais, $model);

        if ($checkValidacao instanceof RedirectResponse) {
            return $checkValidacao;
        }

        Auth::attempt($credenciais);
        Session::flash('sucesso', 'O login foi efetuado com sucesso!');
        return redirect()->intended('vendas');
    }

    //APLICAÇÃO SAIR
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');

    }


}
