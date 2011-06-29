<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class FileSystemCommandResolver implements commandResolver {
    private $path;
    private $defaultCommand;

    public function  __construct($path, $defaultCommand) {
        $this->path = $path;
        $this->defaultCommand = $defaultCommand;
    }

    public function getCommand(Request $request)  {
        //var_dump($request->issetParameter('mode'));
        if($request->issetParameter('mode')) {
            $cmdName = $request->getParameter('mode');
           // var_dump($cmdName);
            $command = $this->loadCommand($cmdName);
           // var_dump($command instanceof command);
            if($command instanceof command) {
                return $command;
            }

        }
        $command = $this->loadCommand($this->defaultCommand);
        return $command;
    }

    /**
     * Hier baue ich noch einen mode to command Mapper ein.
     * Ich möchte nicht allzu viel von meinem Filesystem
     * feil geben. Aus diesem grunde Abstrakte Klasse
     * welche alles auf alles mapt
     * @param <type> $cmdName
     */
    protected function loadCommand($cmdName) {
        $fileName = modeMapperFile::getFileName($cmdName);
        $class = modeMapperFile::getClassName($fileName);
       // var_dump($class);
        if(!file_exists($fileName)) {
            return FALSE;
        }
        include_once $fileName;
        if(!class_exists($class)) {
            return FALSE;
        }
        $command = new $class();
        return $command;
    }

}
?>
