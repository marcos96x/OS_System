<?php

class Tpl
{
    public static function view($tpl, $data = null)
    {
        $tpl = preg_replace('/\./', '/', $tpl);
        $ds = DIRECTORY_SEPARATOR;
        $file = 'view' . $ds . $tpl . '.php';
        ob_start();
        (!file_exists($file)) ? die('Arquivo view' . $ds . $tpl . '.php inexistente.') : '';
        require_once 'view' . $ds . $tpl . '.php';
        $content = ob_get_contents();
        if (preg_match_all('/\@\((.*?)\)/', $content, $p)) {
            if (isset($p[1])) {
                foreach ($p[1] as $m) {
                    $n = self::import($m, $data);
                    $content = str_replace("@($m)", $n, $content);
                }
            }
        }
        $content = self::set_variables($content);
        if (isset($data['mapper']) && !empty($data['mapper'])) {
            foreach ($data['mapper'] as $map) {
                foreach ($data["$map"] as $k => $v) {
                    $content = str_replace('${' . $k . '}', $v, $content);
                }
            }
        }
        ob_end_clean();
        echo $content;
    }

    private static function set_variables($content = null)
    {
        if (preg_match('/\@tokenService/', $content))
            $content = str_replace('@tokenService', TokenService::generate(), $content);
        if (preg_match('/\@globalCss/', $content))
            $content = str_replace('@globalCss', GlobalSource::get_css(), $content);
        if (preg_match('/\@globalJs/', $content))
            $content = str_replace('@globalJs', GlobalSource::get_js(), $content);
        if (preg_match('/\${language}/', $content))
            $content = str_replace('${language}', GlobalSource::get_language(), $content);
        if (preg_match('/\${app_name}/', $content))
            $content = str_replace('${app_name}', GlobalSource::get_app_name(), $content);
        if (preg_match('/\${baseUri}/', $content))
            $content = str_replace('${baseUri}', Http::base(), $content);
        if (preg_match('/\${rand}/', $content))
            $content = str_replace('${rand}', rand(0, 5000), $content);
        if (preg_match('/\${currentYear}/', $content))
            $content = str_replace('${currentYear}', date("Y"), $content);

        return $content;
    }

    public static function import($partial, $datax)
    {
        global $data;
        $data = $datax;
        $partial = preg_replace('/\./', '/', $partial);
        $ds = DIRECTORY_SEPARATOR;
        $file = 'view' . $ds . $partial . '.php';
        if (file_exists($file)) {
            ob_start();
            require_once 'view' . $ds . $partial . '.php';
            $icontent = ob_get_contents();
            if (preg_match_all('/\@\((.*?)\)/', $icontent, $p)) {
                if (isset($p[1])) {
                    foreach ($p[1] as $m) {
                        $n = self::import_step($m, $data);
                        $icontent = str_replace("@($m)", $n, $icontent);
                    }
                }
            }
            ob_end_clean();
            return $icontent;
        } else {
            return 'view' . $ds . $partial . '.php inexistente.';
        }
    }

    public static function import_step($partial, $datax)
    {
        global $data;
        $data = $datax;
        $partial = preg_replace('/\./', '/', $partial);
        $ds = DIRECTORY_SEPARATOR;
        $file = 'view' . $ds . $partial . '.php';
        if (file_exists($file)) {
            ob_start();
            require_once 'view' . $ds . $partial . '.php';
            $ricontent = ob_get_contents();
            ob_end_clean();
            return $ricontent;
        } else {
            return 'view' . $ds . $partial . '.php inexistente.';
        }
    }
}
