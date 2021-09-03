<?php

class Request
{    
    static public function post($key = null, $parse = null, $value = null)
    {
        if ($key == null && $value == null) {
            if (isset($_POST) && !empty($_POST)) {
                return $_POST;
            } else {
                return false;
            }
        } else {
            if ($value == null) {
                if (isset($_POST[$key])) {
                    if ($parse != null) {
                        $_POST[$key] = self::parse($_POST[$key], $parse);
                    }
                    return $_POST[$key];
                } else {
                    return false;
                }
            } else {
                if ($value == 'drop') {
                    if(isset($_POST[$key])){
                        $drop = $_POST[$key];
                        unset($_POST[$key]);
                        return $drop;
                    }
                } else {
                    $_POST[$key] = $value;
                    if ($parse != null) {
                        $_POST[$key] = self::parse($_POST[$key], $parse);
                    }
                    return $_POST[$key];
                }
            }
        }
    }
    
    static public function get($key = null, $value = null, $parse = null)
    {
        if ($key == null && $value == null) {
            if (isset($_GET) && !empty($_GET)) {
                return $_GET;
            } else {
                return false;
            }
        } else {
            if ($value == null) {
                if (isset($_GET[$key])) {
                    if ($parse != null) {
                        $_GET[$key] = self::parse($_GET[$key], $parse);
                    }
                    return $_GET[$key];
                }
            } else {
                
                if ($value == 'drop') {
                    unset($_GET[$key]);
                } else {
                    $_GET[$key] = $value;
                    if ($parse != null) {
                        $_GET[$key] = self::parse($_GET[$key], $parse);
                    }
                    return $_GET[$key];
                }
            }
        }
    }
    
    static public function parse($val, $type)
    {
        if ($type == 'string') {
            return addslashes($val);
        }
        if ($type == 'int') {
            return intval($val);
        }
        if ($type == 'upper') {
            return strtoupper($val);
        }
        if ($type == 'lower') {
            return strtolower($val);
        }
        if ($type == 'md5') {
            return md5($val);
        }
        if ($type == 'strip') {
            return stripslashes(trim($val));
        }
        if ($type == 'moeda') {
            return preg_replace(array('/,/', '/./'), array('', ''), $val);
        }
    }

    static public function all() {
        return (object) Filter::parse_full($_POST);
    }
}
