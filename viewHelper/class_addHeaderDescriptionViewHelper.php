
<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class addHeaderDescriptionViewHelper implements ViewHelper {
    public function execute($args=array()) {
        $reg = registry::getInstance();
        $headerDescription = $reg->getDescription();
        if(!$headerDescription) {
            return STANDARD_DESCRIPTION;
        }
        else
            return $headerDescription;
    }
}
?>

