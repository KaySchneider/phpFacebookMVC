<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class getUserNameByIdViewHelper implements ViewHelper {
    /**
     * Erwartet eine User Id und holt dann den userNamen aus der DB
     * @param <type> $args
     * @return <type>
     */
     public function execute($args=array()) {
        $userId = $args[0];
        $user = new user();
        $user->getUserById($userId);
         if(!empty($user->fb_userLink) &&!empty($user->fb_userId)) {
            $facebook = facebookFactory::getInstance();
            $fbObject = $facebook->getFacebook();
            $fbWorker = new FacebookOperation($fbObject);
           $image = $fbWorker->getUserPic($user->fb_userId);
            $return = '<img src="'.$image.'" /><br/><a target="_blank" href="'.$user->fb_userLink.'">'.$user->name.'</a>';
        }
        else
            $return = $user->name;
       

        return $return;
    }
}
?>
