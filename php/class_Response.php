<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface Response {
    public function setStatus($status);
    public function addHeader($name, $value);
    public function write($data);
    public function flush();
}
?>
