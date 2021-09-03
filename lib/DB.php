<?php

class DB
{
    public $host;
    public $base;
    public $user;
    public $pass;
    public $con;
    public $res;
    public function __construct()
    {
        $database = parse_ini_file('config/main.conf', 1)['database'];
        $this->host = $database['host'];
        $this->base = $database['base'];
        $this->user = $database['user'];
        $this->pass = $database['pass'];
        $this->port = $database['port'];
        $this->con = $this->open();
    }

    public function open()
    {
        try {
            $this->con = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->base", $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->con->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
            $this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->con->exec("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        } catch (PDOException $e) {
            if ($e->getCode() === 1049) {                
                (new Page)->error('Banco de dados [' . $this->base . '] não encontrado! <br> Verifique o arquivo config/database.conf');
            }
            if ($e->getCode() === 1045) {                
                (new Page)->error('Dados de acesso (usuário/senha) ao banco de dados, incorretos!. <br> Verifique o arquivo config/database.conf');
            }
            if ($e->getCode() === 2005) {                
                (new Page)->error('Endereço do servidor SQL [' . $this->host . '] incorreto. <br> Verifique o parâmetro "host" no arquivo config/database.conf');
            }            
            (new Page)->error($e->getMessage());
            exit;
        }
        return $this->con;
    }
}
