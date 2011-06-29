<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class addHeaderInfoViewHelper implements ViewHelper {
    public function execute($args=array()) {
        $reg = registry::getInstance();
        $headerInfo = $reg->getHeader();
        if(!$headerInfo) {
            return STANDARD_TITLE;
        }
        else
            return $headerInfo;
    }
}
?>
