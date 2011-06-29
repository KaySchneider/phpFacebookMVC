<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface command {
    public function execute(Request $request, Response $response);
}
?>
