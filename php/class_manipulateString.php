<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_manipulateString
 *
 * @author tuxlin
 */
class manipulateString {
    //put your code here
    public function shortenStringBr($string, $maxLength, $maxchars=FALSE) {

        if($maxchars != FALSE) {
            //var_dump(strlen($string));
            if(strlen($string) >= intval($maxchars)) {

              $string = substr($string, 0,(intval($maxchars)-3) );
              $string .= '...';
            }
        }
            $returnString = wordwrap($string, intval($maxLength), '<br/>');
        

        return $returnString;

    }
}
?>
