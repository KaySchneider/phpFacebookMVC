<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class layoutFilterFB implements filter {

    /**
     * Erstellt ein neues View Objekt und Speichert dieses in der registry!
     * @param Request $request
     * @param Response $response 
     */
    public function execute(Request $request, Response $response) {
        $renderEngine = new render('pageFB');
        $reg = registry::getInstance();
        $reg->setView($renderEngine);
    }
}
?>
