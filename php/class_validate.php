<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
class validate {

    /**
     *
     * @param <type> $mail
     * @return <type> Prüft ob ein String eine email Adresse sein kann
     */
    public function checkEmailAddress($mail) {

        if(eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$',$mail))
            return TRUE;
        else
            return FALSE;
    }

    public function checkPrice($price) {
        if(eregi('^[0-9|\.]*$', $price))
            return TRUE;
        else
            return FALSE;
    }
    
    public function checkZip($zip) {
        if(eregi('^[0-9]{5}$',$zip))
            return TRUE;
        else
            return FALSE;
    }
}
?>
