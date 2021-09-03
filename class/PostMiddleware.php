<?php

class PostMiddleware {
    public function __construct() {
        if(isset($_POST) && !empty($_POST)) {
            if(!TokenService::verify()) {
               $this->show_view_error();
            }
        }
    }

    private function show_view_error() {
        $data = [
            'msg' => 'Token de formulário incorreto',
            'mapper' => []
        ];
        Tpl::view('erro.auth', $data, 1);
    }
}