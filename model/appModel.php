<?php

class appModel {
    protected $connect = null;
    // private $bindOptions = [
    //     'string' => PDO::PARAM_STR,
    //     'int' => PDO::PARAM_INT
    // ];

    public function __construct() {
        $this->initApp();
    }

    private function initApp() {
        if($this->connect == null) {
            $db = new DB();
            $this->connect = $db->con;
        } else {
            (new Page)->error("Não foi possível inicializar o DB");
        }
    }

    protected function query($sql = "", $bindParams = [], $isReturned = false) {
        $res = $this->connect->prepare($sql);

        if(isset($bindParams[0])) {
            foreach($bindParams as $bind) {
                $bind = (object) $bind;
                $res->bindParam(":{$bind->name}", $bind->value, PDO::PARAM_STR);
            }
        }

        $res->execute();

        if($isReturned) {
            $rows = $res->fetchAll(PDO::FETCH_OBJ);
            $res->closeCursor();
            unset($db);
            return $rows;
        } else {
            $res->closeCursor();
            unset($db);
        }
    }
}