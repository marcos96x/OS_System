<?php

class Auth extends PostMiddleware
{
    public function __construct()
    {
        parent::__construct();
    }

    public function admin() {
        $login = Request::all();
        if(!self::validator($login)) {
            Http::redirect_to('/?campos-invalidos');
        }
        $funcionario = (new funcionarioModel)->login($login);
        if(isset($funcionario[0])) {
            $funcionario = $funcionario[0];
            Session::init();
            Session::node('uid', $funcionario->funcionario_id);
            Session::node('unome', $funcionario->funcionario_nome);
            Session::node('uemail', $funcionario->funcionario_email);
            Session::node('uperms', $funcionario->funcionario_permissao);
            Http::redirect_to('/os');
        }
        Http::redirect_to('/?login-incorreto');
    }

    public function logout_admin() {
        Session::destroy();
        Http::redirect_to('/');
    }


    private static function validator($data) {
        return isset($data->login) && !empty($data->login) &&
               isset($data->senha) && !empty($data->senha);
    }
}
