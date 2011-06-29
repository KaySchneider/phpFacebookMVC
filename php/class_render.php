<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Diese Klasse rendert den view!
 */
class render {

    private $template;
    private $vars = array();
    private $returnObject;
    private $data;
    private $stringManipulate;
    private $helpers;

    public function __construct($template) {
        $this->template = $template;
        $this->returnObject = new returnObject();
        $this->stringManipulate =  new manipulateString();
    }
    
    
    public function assign($name, $value) {
        if(empty($name) OR empty($value))
               return (array)$this->returnObject->returnError('Name or value is empty',300);
        $this->vars[$name] = $value;
        
        return (array)$this->returnObject->returnSuccess('Allright', TRUE);
    }

    public function __call($methodName, $args) {
        $helper = $this->loadViewHelper($methodName);
        if($helper === null) {
            return "Unbekannter ViewHelper $methodName";
        }
        $val = $helper->execute($args);
        return $val;
    }

    protected function loadViewHelper($helper) {
        $helperName = $helper;
        if(!isset($this->helpers[$helper])) {
            $className = "{$helperName}ViewHelper";
            $fileName = "viewHelper/class_".$className.".php";
            
            if(!file_exists($fileName)) {
                return null;
            }
            include_once($fileName);
            $this->helpers[$helper] = new $className();
        }
        return $this->helpers[$helper];
    }

    public function renderView() {
        ob_start();
        $filename = "html/{$this->template}.php";
        include_once($filename);
        $data = ob_get_clean();
        $this->write($data);

    }

    public function flushData() {
        $this->data = '';
    }

    /**
     *
     * @param <type> $data Befüllen des Temp speichers
     * der Ausgabe!
     */
    private function write($data) {
        $this->data .= $data;
    }

    /**
     *
     * @return <type> Gibt die gerenderte VIEW AUS
     */
    public function getHtml() {
        return $this->data;
    }

    
}
?>
