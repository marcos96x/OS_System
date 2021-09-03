<?php

class osModel extends appModel {

    public function __construct() {
        parent::__construct();
    }

    public function all() {
        $sql = "SELECT os_id, os_titulo, funcionario_nome, os_status, os_funcionario,
            CASE os_prioridade
            WHEN 1 THEN 'Baixa'
            WHEN 2 THEN 'Normal'
            WHEN 3 THEN 'Alta'
            WHEN 4 THEN 'Finalizada'
            WHEN 5 THEN 'Cancelada'
            END AS os_prioridade_label,
            CASE os_prioridade
            WHEN 1 THEN 'badge badge-primary'
            WHEN 2 THEN 'badge badge-warning'
            WHEN 3 THEN 'badge badge-danger'
            WHEN 4 THEN 'badge badge-success'
            WHEN 5 THEN 'badge badge-secondary'
            END AS os_badge,
            DATE_FORMAT(os_created, '%d/%m/%Y às %H:%i') AS os_created,
            (SELECT funcionario_nome FROM funcionario WHERE funcionario_id = os_funcionario) AS funcionario_executor
            FROM os
            JOIN funcionario ON funcionario_id = os_criador
            ORDER BY os_id DESC;
        ";
        return $this->query($sql, [], 1);
    }

    public function find($os_id) {
        
        $sql = "SELECT os_id, os_titulo, os_prioridade, os_funcionario FROM os WHERE os_id = :id";
        $bind = [
            [
                'name' => 'id',
                'value' => $os_id
            ],            
        ];

        return $this->query($sql, $bind, 1);
    }

    public function create($request) {
        
        $sql = "INSERT INTO os (os_titulo, os_prioridade, os_funcionario, os_criador) VALUES (:titulo, :prioridade, :funcionario, :criador)";
        $bind = [
            [
                'name' => 'titulo',
                'value' => $request->os_titulo
            ],
            [
                'name' => 'prioridade',
                'value' => $request->os_prioridade
            ],
            [
                'name' => 'funcionario',
                'value' => $request->os_funcionario
            ],
            [
                'name' => 'criador',
                'value' => $request->os_criador
            ],
        ];

        $this->query($sql, $bind);
    }

    public function update($request) {
        
        $sql = "UPDATE os SET os_titulo = :titulo, os_prioridade = :prioridade, os_funcionario = :funcionario WHERE os_id = :id";
        $bind = [
            [
                'name' => 'titulo',
                'value' => $request->os_titulo
            ],
            [
                'name' => 'prioridade',
                'value' => $request->os_prioridade
            ],
            [
                'name' => 'funcionario',
                'value' => $request->os_funcionario
            ],
            [
                'name' => 'id',
                'value' => $request->os_id
            ],
        ];

        $this->query($sql, $bind);
    }

    public function conclui($os_id) {
        
        $sql = "UPDATE os SET os_status = 1 WHERE os_id = :id";
        $bind = [
            [
                'name' => 'id',
                'value' => $os_id
            ],            
        ];

        return $this->query($sql, $bind);
    }

    public function drop($os_id) {
        
        $sql = "DELETE FROM os WHERE os_id = :id";
        $bind = [
            [
                'name' => 'id',
                'value' => $os_id
            ],            
        ];

        return $this->query($sql, $bind);
    }

}