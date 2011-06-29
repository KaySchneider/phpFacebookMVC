<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * <div id="fb-root">
   </div>
   
 */

class facebookRootStatusViewHelper implements ViewHelper {
    public function execute($args=array()) {
        $reg = registry::getInstance();
        $rootStatus = $reg->getFbRoot();
        if(!$rootStatus) {
            return '<div id="fb-root">
                    </div>';
        }
        else
            return '';
        $return = explode(' ', $date);

        return $return[0];
    }
}
?>

