<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Wenn nichts gesetzt ist dann hole die komplette �bersicht!
 *
 * Start Page Command sollte direkt mit der Datensammlung beginnen!
*/


class startPageCommand implements command {

    public function execute(Request $request, Response $response) {
        $req = registry::getInstance();
        $renderEngine = $req->getView();
        $renderOverview = new render('start');

        //get the facebook object and at it to the worker
        $facebook = facebookFactory::getInstance();
        $fbObject = $facebook->getFacebook();
        $fbWorker = new FacebookOperation($fbObject);

        //Daten hier schon aggregieren und likes ausgeben ?
        //Abfragen treffen und Fragen was der nutzer nun möchte
        $renderOverview->renderView();
        $renderEngine->assign('content', $renderOverview->getHtml());
        $req->setView($renderEngine);
    }

}
?>

