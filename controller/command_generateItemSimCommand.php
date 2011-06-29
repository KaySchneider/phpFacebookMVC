<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Wenn nichts gesetzt ist dann hole die komplette Übersicht!
 *
 *
 * Diese Command berechnet den Sim Score für jedes Element. Läuft im Hintergrund,
 * 
*/


class generateItemSimCommand implements command {

    public function execute(Request $request, Response $response) {
        set_time_limit(0);
        $req = registry::getInstance();
        $renderEngine = $req->getView();
        $renderOverview = new render('showLikes');
        $likeDataCollecter = new loadData();
        //Hole Facebook Factory
        //$facebook = facebookFactory::getInstance();
        //$fbObject = $facebook->getFacebook();
        //$fbWorker = new FacebookOperation($fbObject);

        //$likesCollecter = new collectData($fbWorker);
        //$likes = $likesCollecter->startCollectLikes();


       // $empfehlen = new empfehlen;
       // var_dump($empfehlen->getEmpfehlung($kritiken, 'Toby', simFactory::simFact($simMethod)));
       // $transform = new transformPrefs();
       // $FilmKrit = $transform->transform($kritiken);
       // $matches = $topMatch->topMatch($FilmKrit, 'Superman Returns', 5);
       // print "<pre>";
       // var_dump($matches);
       // print "</pre>";


        //$simmilarity = new calculateSimmilaryItems();
        //var_dump($likes[0]);die();
       //$topMatches = $simmilarity->generateSimItems($likes[0]) ;

       $likes = $likeDataCollecter->returnUserLikes(0);
       var_dump($likes);
       $recom = new calculateSimmilaryItems();
       $likesOutput = $recom->generateSimItems($likes);
       var_dump($likesOutput);
       //Alle Daten in likeOutput müsen in der Datenbank gespeichert werden.
       //Somit können alle Daten
       //$renderOverview->assign('likes', $likesOutput);
        $renderOverview->renderView();
        $renderEngine->assign('content', $renderOverview->getHtml());
        $req->setView($renderEngine);
    }

}
?>

