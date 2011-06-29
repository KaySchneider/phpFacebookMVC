<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class viewFBFriendsViewHelper implements ViewHelper {
    public function execute($args=array()) {
        $reg = registry::getInstance();
        /**
         * FB userdaten holen!
         */
        
        $facebook = facebookFactory::getInstance();
        $fbObject = $facebook->getFacebook();
        $fbWorker = new FacebookOperation($fbObject);

        $fbFriends = $fbWorker->getUserFriends();

        /*
         * In DB prüfen welcher Freund schon hier auf dem Marktplatz ist!
         * Einfach alle Freunde ausgeben!
         */
        $friendsPics = '';
         if(is_array($fbFriends['data'])) {
             
            foreach($fbFriends['data'] as $friendArr) {
                $user = new user();
                $isFriend = $user->getUserByFB($friendArr['id']);
                
                if(isset($user->id)) {
                    $friendsPics .= '<div style="float:left"><img src="'.$fbWorker->getUserPic($friendArr['id']).'" /><br/><a>'.$friendArr['name'].'</div>';
                }
                unset($user);
            }
         }
         /*
          * $friendsPics = '<img src="'.$fbWorker->getUserPic($friendArr['id']).'" /><br/><a>'.$friendArr['name'].'</a>';
          */
         if(empty($friendsPics))
             return '<a href="?mode=plain&action=invite">Noch keiner deiner Freunde nutzt Facebook Kleinanzeigen! Lade Sie zu deinem Marktplatz ein. Je mehr Freunde mitmachen desto sozialer ist die Kleinanzeige!</a>';
         return $friendsPics;
        
    }
}
?>
