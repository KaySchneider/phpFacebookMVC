<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Wenn nichts gesetzt ist dann hole die komplette �bersicht!
 *
 * Start Page Command sollte direkt mit der Datensammlung beginnen!
*/


class likesCommand implements command {

    public function execute(Request $request, Response $response) {
        set_time_limit(0);
        $req = registry::getInstance();
        $renderEngine = $req->getView();
        $renderOverview = new render('showLikes');

        //Hole Facebook Factory
        $facebook = facebookFactory::getInstance();
        $fbObject = $facebook->getFacebook();
        $fbWorker = new FacebookOperation($fbObject);

        $likesCollecter = new collectData($fbWorker);
        $likes = $likesCollecter->startCollectLikes();
        

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
       
       $empfehlungsEngine = new empfehlen();
       $simClass = simFactory::simFact('vektor');
       $topMatches = $empfehlungsEngine->getEmpfehlung($likes[0], $likes[2], $simClass);

      

       $likeMaker = new getUserNewLikes($topMatches, $fbWorker);
       //$newlikes = $likeMaker->getUserTopMatches();
       $likesOutput = $likeMaker->makeOutputArray($topMatches, $likes[1]);
       $renderOverview->assign('likes', $likesOutput);
        //$renderOverview->assign('likesDetails', $newLikesDe);

        $renderOverview->renderView();
        $renderEngine->assign('content', $renderOverview->getHtml());
        $req->setView($renderEngine);
    }

}
?>

