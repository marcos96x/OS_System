<?php

Class Page
{

    public function __construct()
    {

    }

    public function indexAction()
    {
    }

    public function error($msg = 'Conteúdo não disponível') {
        $data = [
            'msg' => ['msg' => $msg],
            'mapper' => ['msg']
        ];
        Tpl::view("erro.index", $data);
    }
}
