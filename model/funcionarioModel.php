<?php

class funcionarioModel extends appModel {

    public function __construct() {
        parent::__construct();
    }

    public function login($requestLogin) {
        $requestLogin->senha = md5($requestLogin->senha);
        $sql = "SELECT * FROM funcionario WHERE funcionario_login = :login AND funcionario_senha = :senha";
        $bind = [
            [
                'name' => 'login',
                'value' => $requestLogin->login
            ],
            [
                'name' => 'senha',
                'value' => $requestLogin->senha
            ],
        ];

        return $this->query($sql, $bind, 1);
    }

    public function all() {
        $sql = "SELECT funcionario_id, funcionario_nome,
            CASE funcionario_permissao
            WHEN 1 THEN 'Administrativo'
            WHEN 2 THEN 'Operacional'
            END AS funcionario_nivel,
            (SELECT COUNT(*) FROM os WHERE os_criador = funcionario_id) AS funcionario_qtd_os_criada,
            (SELECT COUNT(*) FROM os WHERE os_funcionario = funcionario_id AND os_status = 1) AS funcionario_qtd_os_executada
            FROM funcionario
            ORDER BY funcionario_id DESC
        ;
        ";
        return $this->query($sql, [], 1);
    }

    public function operadores() {
        $sql = "SELECT funcionario_id, funcionario_nome,
            CASE funcionario_permissao
            WHEN 1 THEN 'Administrativo'
            WHEN 2 THEN 'Operacional'
            END AS funcionario_nivel,
            (SELECT COUNT(*) FROM os WHERE os_criador = funcionario_id) AS funcionario_qtd_os_criada,
            (SELECT COUNT(*) FROM os WHERE os_funcionario = funcionario_id AND os_status = 1) AS funcionario_qtd_os_executada
            FROM funcionario
            WHERE funcionario_permissao = 2
            ORDER BY funcionario_id DESC
        ;
        ";
        return $this->query($sql, [], 1);
    }

    public function find($funcionario_id) {
        
        $sql = "SELECT funcionario_id, funcionario_permissao, funcionario_login, funcionario_nome FROM funcionario WHERE funcionario_id = :id";
        $bind = [
            [
                'name' => 'id',
                'value' => $funcionario_id
            ],            
        ];

        return $this->query($sql, $bind, 1);
    }

    public function create($request) {
        
        $bind = [
            [
                'name' => 'nome',
                'value' => $request->funcionario_nome
            ],
            [
                'name' => 'permissao',
                'value' => $request->funcionario_permissao
            ],
            [
                'name' => 'login',
                'value' => $request->funcionario_login
            ],
            [
                'name' => 'senha',
                'value' => md5($request->funcionario_senha)
            ]
        ];
        $sql = "INSERT INTO funcionario VALUES (DEFAULT, :permissao, :nome, :login , :senha)";

        $this->query($sql, $bind);
    }

    public function update($request) {
        $bind = [
            [
                'name' => 'id',
                'value' => $request->funcionario_id
            ],
            [
                'name' => 'nome',
                'value' => $request->funcionario_nome
            ],
            [
                'name' => 'permissao',
                'value' => $request->funcionario_permissao
            ],
            [
                'name' => 'login',
                'value' => $request->funcionario_login
            ],
        ];

        $update_senha = "";
        if(isset($request->funcionario_senha) && !empty($request->funcionario_senha)) {
            $bind[] = [
                'name' => 'senha',
                'value' => md5($request->funcionario_senha)
            ];
            $update_senha = ", funcionario_senha = :senha";
        }
        $sql = "UPDATE funcionario SET funcionario_nome = :nome, funcionario_permissao = :permissao, funcionario_login = :login $update_senha WHERE funcionario_id = :id";

        $this->query($sql, $bind);
    }

    public function drop($funcionario_id) {
        
        $sql = "DELETE FROM funcionario WHERE funcionario_id = :id";
        $bind = [
            [
                'name' => 'id',
                'value' => $funcionario_id
            ],            
        ];

        return $this->query($sql, $bind);
    }


}