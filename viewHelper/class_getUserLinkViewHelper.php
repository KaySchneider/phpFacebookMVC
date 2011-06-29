<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class getUserLinkViewHelper implements ViewHelper {
    /**
     * Erwartet eine User Id und holt dann den userNamen aus der DB
     * @param <type> $args
     * @return <type>
     */
     public function execute($args=array()) {
        $user = $args[0];
        if(!empty($user->fb_userLink) &&!empty($user->fb_userId)) {
            $facebook = facebookFactory::getInstance();
            $fbObject = $facebook->getFacebook();
            $fbWorker = new FacebookOperation($fbObject);
           $image = $fbWorker->getUserPic($user->fb_userId);
            $return = '<img src="'.$image.'" /><a target="_blank" href="'.$user->fb_userLink.'">'.$user->name.'</a>';
        }
        else
            $return = $user->name;
        return $return;
    }
}
?>
