<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface commandResolver {
    public function getCommand(Request $request);
}
?>
