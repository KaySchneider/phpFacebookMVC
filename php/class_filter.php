<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface filter {
    public function execute(Request $request, Response $response);
}
?>
