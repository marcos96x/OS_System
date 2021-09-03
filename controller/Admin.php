<?php

class Admin extends PostMiddleware
{
    public function __construct()
    {
        @session_start();
        parent::__construct();
    }

    static public function check()
    {
        if (!Session::check() || !Session::node('uid')) {
            Session::destroy();
            Http::redirect_to('/?acesso-negado');
        }
    }

    public function indexAction() {
      Http::redirect_to('/os');
    }

 
   
}
