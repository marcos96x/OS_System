<?php

class Http
{
    public static function base()
    {
        $baseuri = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') .
            (isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] . '@' : '') .
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] .
                (isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] === 443 ||
                $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT']))) .
            substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
        return $baseuri;
    }

    public static function redirect($url = '')
    {
        if (!headers_sent()) {
            header('Location: ' . $url);
            exit;
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . $url . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
            echo '</noscript>';
        }
    }

    public static function redirect_to($url = '')
    {
        $url = Http::base() . "$url";
        if (!headers_sent()) {
            header('Location: ' . $url);
            exit;
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . $url . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
            echo '</noscript>';
        }
    }

    public static function get_param($key, $parse = 'string')
    {
        $uri = filter_input(INPUT_GET, 'rota', FILTER_SANITIZE_SPECIAL_CHARS);
        $uri = explode("/", $uri);
        if (array_key_exists($key, $uri)) {
            if ($parse == 'int') {
                $uri[$key] = intval($uri[$key]);
            }
            if ($parse == 'string') {
                $uri[$key] = addslashes($uri[$key]);
            }            
            return $uri[$key];
        } else {
            return false;
        }
    }

    public static function get_all_params()
    {
        $uri = filter_input(INPUT_GET, 'rota', FILTER_SANITIZE_SPECIAL_CHARS);
        return explode("/", $uri);
    }

    public static function get_in_params($param, $type = null)
    {
        $params = self::get_all_params();
        $res = false;
        if (in_array("$param", $params)) {
            $key = array_keys($params, $param)[0];
            $value = Http::get_param($key + 1);
            if ($type != null) {
                switch ($type) {
                    case 'int':
                        $value = intval($value);
                        if ($value <= 0) {
                            return false;
                            exit;
                        }
                        break;
                }
            }
            $res = (object)['key' => $key, 'value' => $value];
        }
        return $res;
    }
}
