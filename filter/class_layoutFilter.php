<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class layoutFilter implements filter {

    /**
     * Erstellt ein neues View Objekt und Speichert dieses in der registry!
     * @param Request $request
     * @param Response $response 
     */
    public function execute(Request $request, Response $response) {
        if($request->issetParameter('s')) {
            $source = $request->getParameter('s');
            if(!empty($source) && $source=='i') {
                $renderEngine = new render('userEmbedShop');
            }
        }
        if(!$renderEngine  instanceof  render)
            $renderEngine = new render('page');
        $reg = registry::getInstance();
        $reg->setView($renderEngine);
    }
}
?>
