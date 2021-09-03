<?php

class Index
{

    public function __construct()
    {
    }

    public function indexAction()
    {
        $data = [
            'mapper' => []
        ];
        Tpl::view('admin.pages.login.index', $data, 1);
    }
}
