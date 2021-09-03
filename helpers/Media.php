<?php

class Media
{

    static public function upload($file, $dir, $type = 'img', $newname = null)
    {
        if ($type == 'img') {
            return self::img_upload($file, $dir, $newname);
        }
        if ($type == 'file') {
            return self::file_upload($file, $dir, $newname);
        }
    }

    static public function img_upload($file, $pasta = '', $newname = null)
    {
        // caso não for usado dentro de um foreach para as imagens
        $arquivo_tmp = $file['tmp_name'];
        $nome = $file['name'];
        if (!empty($nome) && !empty($arquivo_tmp)) {
            $ds = DIRECTORY_SEPARATOR;
            $dir = Path::base();
            $basepath = $dir . $ds . 'media' . $ds . $pasta;
            if (!is_dir("$basepath")) {
                mkdir("$basepath", 0775);
            } else {
                @system("sudo chmod -R 777 $basepath");
            }
            // Pega a extensão
            $extensao = pathinfo($nome, PATHINFO_EXTENSION);
            // Converte a extensão para minúsculo
            $extensao = strtolower($extensao);
            // Somente imagens
            if (strstr('.jpg;.jpeg;.png;.gif', $extensao)) {
                // cria novo nome para a img
                $nome_arquivo = explode(".", $nome);
                $nome_arquivo[0] = str_replace('.', '-', $nome_arquivo[0]);
                if ($newname == null) {
                    $novoNome = Filter::slug($nome_arquivo[0] . '-' . date('d-m-Y') . '-' . uniqid(time())) . '.' . $extensao;
                } else {
                    $novoNome = $newname . '.' . $extensao;
                }
                $novoNome = FIlter::slug($novoNome);
                // Concatena a pasta com o nome
                $destino = $basepath . $ds . $novoNome;
                // tenta mover o arquivo para o destino
                if (getimagesize($file["tmp_name"])) {
                    if (move_uploaded_file($arquivo_tmp, $destino)) {
                        // arquivo movido com sucesso
                        @system("sudo chmod -R 755 $destino");
                        $tamanho = filesize($destino);
                        $data = (object)['size' => $tamanho, 'url' => $novoNome, 'ext' => $extensao, 'path' => $destino];
                        return $data;
                    }
                }
            } else {
                // formato nao permitido
                return 1;
                exit;
            }
        } else {            
            return -1;
            exit;
        }
    }

    static public function img_rotaciona($img = null, $pasta = null)
    {
        if (strlen($pasta) > 0 && strlen($img) > 0) {
            $dir = Path::base();
            $ds = DIRECTORY_SEPARATOR;
            $path = $dir . $ds . 'media' . $ds . $pasta . $ds . $img;
            list($width, $height, $image_type) = getimagesize($path);
            switch ($image_type) {
                case 1:
                    $src = imagecreatefromgif($path);
                    break;
                case 2:
                    $src = imagecreatefromjpeg($path);
                    break;
                case 3:
                    $src = imagecreatefrompng($path);
                    break;
                default:
                    return '';
                    break;
            }
            $tmp = imagerotate($src, -90, 0);
            ob_start();
            switch ($image_type) {
                case 1:
                    imagegif($tmp);
                    break;
                case 2:
                    imagejpeg($tmp, NULL, 100);
                    break; // best quality
                case 3:
                    imagepng($tmp, NULL, 100);
                    break; // no compression
                default:
                    echo '';
                    break;
            }
            $final_image = ob_get_contents();
            $f = fopen("$path", "w");
            fwrite($f, $final_image);
            fclose($f);
            ob_end_clean(); // limpa o buffer de saida
            return 1;
        } else {
            return 0;
        }
    }

    static public function img_redimensiona($img = null, $pasta = null, $quality = 70)
    {
        if (strlen($pasta) > 0 && strlen($img) > 0) {
            $dir = Path::base();
            $ds = DIRECTORY_SEPARATOR;
            $path = $dir . $ds . 'media' . $ds . $pasta . $ds . $img;
            list($width, $height, $image_type) = getimagesize($path);
            switch ($image_type) {
                case 1:
                    $src = imagecreatefromgif($path);
                    break;
                case 2:
                    $src = imagecreatefromjpeg($path);
                    break;
                case 3:
                    $src = imagecreatefrompng($path);
                    break;
                default:
                    return '';
                    break;
            }
            ob_start();
            switch ($image_type) {
                case 1:
                    imagegif($src);
                    break;
                case 2:
                    imagejpeg($src, NULL, $quality);
                    break;
                case 3:
                    imagepng($src, NULL, $quality);
                    break;
                default:
                    echo '';
                    break;
            }
            $final_image = ob_get_contents();
            $f = fopen("$path", "w");
            fwrite($f, $final_image);
            fclose($f);
            ob_end_clean(); // limpa o buffer de saida
            $tamanho = filesize($path);
            return $tamanho;
        } else {
            return 0;
        }
    }

    static public function file_upload($file, $pasta = '', $newname = null)
    {
        // caso não for usado dentro de um foreach para as imagens
        $arquivo_tmp = $file['tmp_name'];
        $nome = $file['name'];
        if (!empty($nome) && !empty($arquivo_tmp)) {
            $ds = DIRECTORY_SEPARATOR;
            $dir = Path::base();
            $basepath = $dir . $ds . 'media' . $ds . $pasta;
            if (!is_dir("$basepath")) {
                @mkdir("$basepath", 0777);
            } else {
                @system("chmod -R 777 $basepath");
            }
            // Pega a extensão
            $extensao = pathinfo($nome, PATHINFO_EXTENSION);
            // Converte a extensão para minúsculo
            $extensao = strtolower($extensao);
            // Somente arquivos nos formatos permitidos
            if (strstr('.jpg;.jpeg;.png;.gif;.pdf;.doc;.docx;.xls;.xlx;.txt;.ppt;.pptx;.zip;.rar', $extensao)) {
                // cria novo nome para a img
                $nome_arquivo = explode(".", $nome);
                $nome_arquivo[0] = str_replace('.', '-', $nome_arquivo[0]);
                if ($newname == null) {
                    $novoNome = $nome_arquivo[0] . '-' . date('d-m-Y') . '-' . uniqid(time()) . '.' . $extensao;
                } else {
                    $novoNome = $newname . '.' . $extensao;
                }

                $novoNome = FIlter::slug($novoNome);
                // Concatena a pasta com o nome
                $destino = $basepath . $ds . $novoNome;
                // tenta mover o arquivo para o destino
                if (@move_uploaded_file($arquivo_tmp, $destino)) {
                    // arquivo movido com sucesso
                    @system("chmod -R 755 $destino");
                    $tamanho = filesize($destino);
                    $data = (object)['size' => $tamanho, 'name' => $novoNome, 'ext' => $extensao, 'path' => $destino];
                    return $data;
                } else {
                    echo -1;
                    exit;
                }
            } else {
                // formato nao permitido
                echo 0;
                exit;
            }
        } else {
            echo 0;
            exit;
        }
    }
}