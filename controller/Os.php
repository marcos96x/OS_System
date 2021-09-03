<?php

class Os
{
    private $model = null;
    public function __construct()
    {
        @session_start();
        Admin::check();
        $this->model = new osModel();
    }

    public function indexAction() {
        $data = [
            'mapper' => []
        ];
        Tpl::view('admin.pages.os.index', $data, 1);
    }

    public function nova() {
        if(Session::node('uperms') == 2) {
            Http::redirect_to('/admin/?error');
        }
        $data = [
            'action' => 'Adicionar',
            'os_id' => '',
            'mapper' => []
        ];
        Tpl::view('admin.pages.os.form', $data, 1);
    }

    public function editar() {
        if(Session::node('uperms') == 2) {
            Http::redirect_to('/admin/?error');
        }
        $id = Http::get_in_params('editar', 'int');
        if(isset($id->value) && $id->value > 0) {
            $data = [
                'action' => 'Editar',
                'os_id' => $id->value,
                'mapper' => []
            ];
            Tpl::view('admin.pages.os.form', $data, 1);
        } else {
            Http::redirect_to('/os/?error');
        }
    }

    public function lista() {
        $os =  $this->model->all();
        Response::send(200, $os);
    }

    public function find() {
        $os_id = Http::get_in_params('find', 'int');
        if(isset($os_id->value) && $os_id->value > 0) {
            $os =  $this->model->find($os_id->value);
            if(isset($os[0])) {
                Response::send(200, $os[0]);
            } else {
                Response::send(404);
            }
        } else {
            Response::send(403, ['msg' => 'ID da OS não informado']);
        }
    }

    public function gravar() {
        $os = Request::all();
        if(!self::validator($os)) {
            Http::redirect_to('/os/?error');
        }
        $os->os_criador = Session::node('uid');
        if(intval($os->os_id) > 0) {
            $this->model->update($os);
        } else {
            $this->model->create($os);
        }
        Http::redirect_to('/os/?success');
    }

    public function remove() {
        $os_id = Request::post('id', 'int');
        if(!empty($os_id) && $os_id > 0) {
            $this->model->drop($os_id);
            Response::send(200);            
        } else {
            Response::send(403, ['msg' => 'ID da OS não informado']);
        }
    }

    public function conclui() {
        $os_id = Request::post('id', 'int');
        if(!empty($os_id) && $os_id > 0) {
            $this->model->conclui($os_id);
            Response::send(200);            
        } else {
            Response::send(403, ['msg' => 'ID da OS não informado']);
        }
    }
   
    private static function validator($data) {
        return isset($data->os_titulo) && !empty($data->os_titulo) &&
               isset($data->os_prioridade) && !empty($data->os_prioridade);
    }
}
