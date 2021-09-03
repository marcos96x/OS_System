<?php 

class GlobalSource {

    static function get_css() {
        $config = parse_ini_file('config/main.conf', 1)['assets'];
        $cssArray = explode(",", $config['css']);
        $exports = "";
        if(isset($cssArray[0])) {
            
            foreach($cssArray as $css) {
                $uri = Http::base() . '/global/css/' . $css;
                $exports .= "<link href='{$uri}' rel='stylesheet'>";
            }
        }
        return $exports;
    }

    static function get_js() {
        $config = parse_ini_file('config/main.conf', 1)['assets'];
        $jsArray = explode(",", $config['js']);
        $exports = "";
        if(isset($jsArray[0])) {
            foreach($jsArray as $js) {
                $uri = Http::base() . '/global/js/' . $js;
                $exports .= "<script src='{$uri}'></script>";
            }
        }
        return $exports;
    }

    static function get_language() {
        $config = parse_ini_file('config/main.conf', 1)['config'];
        return $config['language'];
    }

    static function get_app_name() {
        $config = parse_ini_file('config/main.conf', 1)['config'];
        return $config['app-name'];
    }
    
}