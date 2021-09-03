<?php 
@session_start();
class TokenService {

    static function generate() {
        $_SESSION["tokenService"] = self::createToken();
        $tokenField = "<input type='hidden' name='_tokenService' value='". $_SESSION["tokenService"] ."' >";
        return $tokenField;
    }

    static function verify() {
        $token = Request::post('_tokenService', 'string');
        if(isset($_SESSION["tokenService"]) && !empty($token) && $token == $_SESSION["tokenService"]) {
            unset($_POST['_tokenService']);
            unset($_POST['tokenService']);
            return true;
        }
        return false;
    }

    private static function createToken() {
        return md5(time());
    }
    
}