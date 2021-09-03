<?php
@session_start(['cookie_lifetime' => 86400]);

Class Session
{

    static public function start()
    {
        @session_start();
    }

    static public function init($timeLife = 10000)
    {
        $_SESSION['ACTIVITY_ID'] = md5(uniqid(time()));
        $_SESSION['START_ACTIVITY'] = time();
        $_SESSION['START_ACTIVITY_H'] = date('d/m/Y H:i:s');
        $_SESSION['LAST_ACTIVITY'] = time();
        $_SESSION['LIFE_TIME'] = $timeLife;
    }

    static public function node($key, $value = null)
    {
        if ($value == null) {
            if (isset($_SESSION['node'][$key])) {
                return $_SESSION['node'][$key];
            } else {
                return false;
            }
        } else {
            if (isset($key)) {
                $_SESSION['node'][$key] = $value;
            }
        }
    }

    static public function client_node($key, $value = null)
    {
        if ($value == null) {
            if (isset($_SESSION['clientNode'][$key])) {
                return $_SESSION['clientNode'][$key];
            } else {
                return false;
            }
        } else {
            if (isset($key)) {
                $_SESSION['clientNode'][$key] = $value;
            }
        }
    }

    static public function node_drop($key)
    {
        if (isset($_SESSION['node'][$key])) {
            unset($_SESSION['node'][$key]);
        }
    }

    static public function nodes_distroy()
    {
        if (isset($_SESSION['node'])) {
            unset($_SESSION['node']);
        }
    }

    static public function check()
    {
        return isset($_SESSION['LAST_ACTIVITY']);
    }

    static public function destroy()
    {
        self::nodes_distroy();
        @session_destroy();
    }

}

/* end file */