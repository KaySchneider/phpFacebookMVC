<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface Request {
    public function getParameterNames();
    public function issetParameter($name);
    public function getParameter($name);
    public function getHeader($name);
    public function getRemoteAddress();
}
?>
