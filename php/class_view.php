<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class view {
    
    protected $render;

    public function __construct($template) {
        $this->render = new render($template);
    }

}
?>
