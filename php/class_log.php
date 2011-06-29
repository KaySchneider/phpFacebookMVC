<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface log {
    public function errorLog($className, $methodName, $error);
    public function userLog($userId,$userip);
    public static function getInstance();
}
?>
