<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface Observable {
    public function attach(Observer $observer);
    public function detach(Observer $observer);
    public function notify();
}
?>
