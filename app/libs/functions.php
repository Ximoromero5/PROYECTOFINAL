<?php

function getData($data)
{
    if (isset($_REQUEST[$data]))
        $tmp = strip_tags(sinEspacios($_REQUEST[$data]));
    else
        $tmp = "";

    return $tmp;
}

function sinEspacios($data)
{
    $texto = trim(preg_replace('/ +/', ' ', $data));
    return $texto;
}

//Función que devuelve el nombre de la imágen
function devuelveImagen($nombre, $dir, &$errores, $extensionesValidas)
{
    if ($_FILES[$nombre]['error'] != 0) {
        switch ($_FILES[$nombre]['error']) {
            case 1:
                $errores[$nombre] = "File too large!";
                break;
            case 2:
                $errores[$nombre] = 'The file is too large!';
                break;
            case 3:
                $errores[$nombre] = 'The file could not be uploaded whole!';
                break;
            case 4:
                $errores[$nombre] = 'You must upload a photo!';
                break;
            case 6:
                $errores[$nombre] = "Temporary folder is missing!";
                break;
            case 7:
                $errores[$nombre] = "Could not write to disk!";
                break;
            default:
                $errores[$nombre] = 'Indeterminate Error!';
        }
        return 0;
    } else {

        $nombreArchivo = $_FILES[$nombre]['name'];
        $directorioTemp = $_FILES[$nombre]['tmp_name'];
        $extension = $_FILES[$nombre]['type'];

        if (!in_array($extension, $extensionesValidas)) {
            $errores[$nombre] = "File extension is invalid or no file has been uploaded!";
            return 0;
        }

        if (!isset($errores[$nombre])) {
            $nombreArchivo = $dir . time() . '.' . pathinfo($nombreArchivo, PATHINFO_EXTENSION);

            if (is_dir($dir))
                if (move_uploaded_file($directorioTemp, $nombreArchivo)) {
                    return $nombreArchivo;
                } else {
                    $errores[$nombre] = "You cannot move the file to its destination!";
                    return 0;
                } else
                $errores[] = "You cannot move the file to its destination!";
        }
    }
}
