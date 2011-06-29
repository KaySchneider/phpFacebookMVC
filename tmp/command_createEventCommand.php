<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Wenn nichts gesetzt ist dann hole die komplette �bersicht!
 *
 * Start Page Command sollte direkt mit der Datensammlung beginnen!
 */

class createEventCommand implements command {

   public function execute(Request $request, Response $response) {
        $req = registry::getInstance();
        $renderEngine = $req->getView();
        $renderOverview = new render('showLikes');

        //Hole Facebook Factory
        $facebook = facebookFactory::getInstance();
        $fbObject = $facebook->getFacebook();
        $fbWorker = new FacebookOperation($fbObject);


        //create here the event on facebook as a page
        /*
         *  'name=My birthday' \
            -F 'start_ime=' \
            -F 'end_time=' \
         *
         */
        $eventOptions = array(
               'name'=>'testEEEEvent',
               'start_time' => mktime(18,11,0,5,15,2011),
               'end_time' => mktime(20,11,0,5,15,2011),
               'location'=>'Stuttgart',
               'city'=>'Stuttgart',
               'street'=>'Bahnhofstrasse',
               'privacy_type' => 'OPEN',
               'description'=> "BLA BLA BLA BLA \r\n BLA BLA FOO \r\n - HUUU \r\n FOO \r\n Erstellt mit LikeOmat! \r\n Mehr Informationen: http://geros-flohmarkt.de ",
               'source' => '@' .realpath( BASEPATH . '/tmp/'.'1vGTKB6Q.jpg'),
               'vanue' => json_encode(array(
                              'city'=> "Stuttgart",
                              'state'=> "Baden-Württemberg",
                              'country'=> "Germany",
                              'street'=> 'Bahnhofstrasse',
                              
                           ))
            );
            /**
             * 'latitude'=> 48.783795,
                              'longitude'=> 9.161911
             */
        var_dump( $fbWorker->createEvent($eventOptions, 'me') );

//        );

   }

}
?>


