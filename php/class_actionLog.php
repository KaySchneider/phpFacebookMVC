<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface actionLog {
    public static function getInstance();
    public function logAction($userid, $anz_id);
}
?>
