<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
function autoload_AT($class_name) {
    $fileexists = FALSE;

    //wenn Klasse im selben Verzeichnis
    $basepath = dirname (__FILE__) . DIRECTORY_SEPARATOR;
    $path = $basepath . $class_name . '.php';

    if (file_exists($path)) {
        require_once($path);
        $fileexists = TRUE;
    }

    //Klasse Teil der Zend library
    $path = ZENDDIR . str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';

    if (file_exists($path)) {
        require_once($path);
        $fileexists = TRUE;
    }

    //Wenn Klasse im php Ordner
    $basepath = BASEPATH . DIRECTORY_SEPARATOR .  'php' . DIRECTORY_SEPARATOR;
    $path = $basepath  .'class_'. $class_name . '.php';
    if (file_exists($path)) {
        require_once($path);
        $fileexists = TRUE;
    }

    //Wenn Klasse im filter Ordner
    $basepath = BASEPATH . DIRECTORY_SEPARATOR .  'filter' . DIRECTORY_SEPARATOR;
    $path = $basepath  .'class_'. $class_name . '.php';
    if (file_exists($path)) {
        require_once($path);
        $fileexists = TRUE;
    }

    //Wenn Klasse im eventHandler Ordner
    $basepath = BASEPATH . DIRECTORY_SEPARATOR .  'eventHandler' . DIRECTORY_SEPARATOR;
    $path = $basepath  .'class_'. $class_name . '.php';
    if (file_exists($path)) {
        require_once($path);
        $fileexists = TRUE;
    }





}

spl_autoload_extensions('.php');
spl_autoload_register('autoload_AT');
?>
