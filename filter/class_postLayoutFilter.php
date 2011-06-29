<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class postLayoutFilter implements filter {
    public function execute(Request $request, Response $response) {
        $reg = registry::getInstance();
        $view = $reg->getView();
        //var_dump($view);
        $view->renderView();
        $response->write($view->getHtml());
    }
}
?>
