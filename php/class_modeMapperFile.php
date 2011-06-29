<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
class modeMapperFile implements modeMapper {
    /**
     * In diesem Array sind mode(array_key) und value = Filename
     * So kann dsa ganze später noch zur Laufzeit erweitert werden
     * warum auch immer
     */
    private $fileName;

    static public function getFileName($mode) {
            if(is_file(BASEPATH . DIRECTORY_SEPARATOR . 'controller/command_'.$mode.'Command.php')) {
                return BASEPATH . DIRECTORY_SEPARATOR . 'controller/command_'.$mode.'Command.php';
            }
            else
                return BASEPATH . DIRECTORY_SEPARATOR . 'controller/command_startPageCommand.php';
        
    }

    static public function getClassName($path) {
        $className = explode('_', $path);
        //var_dump($className);
        $className = explode('.php', $className[1]);
        //var_dump($className);
        return $className[0];
    }
}
?>
