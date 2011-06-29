<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Wenn nichts gesetzt ist dann hole die komplette �bersicht!
*/


class startPageCommand implements command {

    public function execute(Request $request, Response $response) {
        $req = registry::getInstance();
        $renderEngine = $req->getView();
        $renderOverview = new render('start');
        $categMenue = new categorie();
        $view = new viewAnzeige();

        $renderOverview->assign('menue', $categMenue->getCategMenue());
        //Overview view erzeugen
        $renderOverview->renderView();

        $renderEngine->assign('content', $renderOverview->getHtml());
        $req->setView($renderEngine);
    }

}
?>

