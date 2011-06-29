<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *`fb_userId` varchar(255) NOT NULL,
  `fb_userLink` varchar(255) NOT NULL,
 * Diese Klasse prüft eingehend ob ein Facebook User existiert und
 * ob dieser über die geforderten Rechte von der Anwendung enthält!
 * Wenn es keine Rechte gibt so versucht dieser Handler diese zu bekomme
 * sind die Rechte vorhanden dann wirft der Filter
 * das facebookUser und der EventHandler prüft ob der Nutzer schon in der
 * Datenbank liegt! Ist dem so dann werden diese Daten gespeichert und
 * und es wird ein System Nutzer angelegt! Dieser enthält noch zusätzlich
 * 
 * die Facebook ID!! Er muss nicht doubleOptIn tätigen!
*/
class facebookUser implements filter {
    public function execute(Request $request, Response $response) {
        $reg = registry::getInstance();
        //$user = new user();
        //$reg->setUser($user);
        $facebook = facebookFactory::getInstance();
        $fbObject = $facebook->getFacebook();
        $fbWorker = new FacebookOperation($fbObject);
        $renderEngine = $reg->getView();
        if(!$renderEngine instanceof render)
            $renderEngine = new render('page');

        /**
         * Prüfen ob der Nutzer die Benötigten Rechte besitzt
         * Keine Rechte, die Rechte holen Nutzer anlegen!
         */
        $userIdFF = $fbWorker->getFB_userId();
        if(!$fbWorker->checkLoginState() && empty($userIdFF)) {
            eventDispatcher::getInstance()->triggerEvent('onFBUserNoRights');
        }
        /**
         * Wenn bis hier dann ist alles OK! nun Prüfen ob der Nutzer zum ersten mal bei uns
         * angelangt ist! wenn ja dann Nutzer anlegen!
         * Problem nutzer werden nach erstkontakt mit der Seite völlig Falsch angelegt, bzw garnicht angelegt
         *
         * Nur Rechte für Anwendung einholen! Den Rest erstmal alles weglassen!
         */

         
        //if(! $_SESSION['userIDFB'] ) {
           /* $fb_userId = $fbWorker->getFB_userId();
            if(!$userId = $user->getUserByFB($fb_userId)) {
                //nuter existiert nicht anlegen !
                $me = $fbWorker->getMe();
                $friends = $fbWorker->getUserFriends();
                
                //    var_dump($me);die();
                /*
                 * Hier event veröffentlichen dass ein Nutzer beginnt die kleinanzeigen app zu verwenden!
                 * /
              **/
        /*
                eventDispatcher::getInstance()->triggerEvent('onFBUserGetRights', $me);
                $user->insertFacebookUser($me['name'], $me['email'], $me['location']['id'], $me['id'], $me['link']);
                
            }    /*freude abholen!*/
           
           
        
    }
}

?>
