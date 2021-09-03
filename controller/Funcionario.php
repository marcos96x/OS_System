<?php

class Funcionario
{
    private $model = null;
    public function __construct()
    {
        @session_start();
        Admin::check();
        $this->model = new funcionarioModel();
    }

    public function indexAction() {
        $data = [
            'mapper' => []
        ];
        Tpl::view('admin.pages.funcionario.index', $data, 1);
    }

    public function novo() {
        $data = [
            'action' => 'Adicionar',
            'funcionario_id' => '',
            'senha_required' => true,
            'mapper' => []
        ];
        Tpl::view('admin.pages.funcionario.form', $data, 1);
    }

    public function editar() {
        $id = Http::get_in_params('editar', 'int');
        if(isset($id->value) && $id->value > 0) {
            $data = [
                'action' => 'Editar',
                'funcionario_id' => $id->value,
                'senha_required' => false,
                'mapper' => []
            ];
            Tpl::view('admin.pages.funcionario.form', $data, 1);
        } else {
            Http::redirect_to('/funcionario/?error');
        }
    }

    public function lista() {
        $funcionario =  $this->model->all();
        Response::send(200, $funcionario);
    }

    public function lista_operadores() {
        $funcionario =  $this->model->operadores();
        Response::send(200, $funcionario);
    }

    public function find() {
        $funcionario_id = Http::get_in_params('find', 'int');
        if(isset($funcionario_id->value) && $funcionario_id->value > 0) {
            $funcionario =  $this->model->find($funcionario_id->value);
            if(isset($funcionario[0])) {
                Response::send(200, $funcionario[0]);
            } else {
                Response::send(404);
            }
        } else {
            Response::send(403, ['msg' => 'ID da funcionario não informado']);
        }
    }

    public function gravar() {
        $funcionario = Request::all();
        if(!self::validator($funcionario)) {
            Http::redirect_to('/funcionario/?error');
        }
        $funcionario->funcionario_criador = Session::node('uid');
        if(intval($funcionario->funcionario_id) > 0) {
            $this->model->update($funcionario);
        } else {
            if(isset($funcionario->funcionario_senha) && !empty($funcionario->funcionario_senha)) {
                $this->model->create($funcionario);
            } else {
                Http::redirect_to('/funcionario/novo/?senha-obrigatoria');
            }
        }
        Http::redirect_to('/funcionario/?success');
    }

    public function remove() {
        $funcionario_id = Request::post('id', 'int');
        if(!empty($funcionario_id) && $funcionario_id > 0) {
            $this->model->drop($funcionario_id);
            Response::send(200);            
        } else {
            Response::send(403, ['msg' => 'ID da funcionario não informado']);
        }
    }
   
    private static function validator($data) {
        return isset($data->funcionario_nome) && !empty($data->funcionario_nome) &&
               isset($data->funcionario_permissao) && !empty($data->funcionario_permissao) &&
               isset($data->funcionario_login) && !empty($data->funcionario_login);
    }
}
