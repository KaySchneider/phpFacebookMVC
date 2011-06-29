<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Erzeugt ein neues Facebook Objekt und liefert es wieder zurück!
*/
include_once('facebook.php');
class facebookFactory {

    private $facebook;
    private static $instance = null;

    private function  __construct() {
        $this->facebook = new Facebook(array(
                        'appId'  => APP_ID,
                        'secret' => APP_SECRET,
                        'cookie' => true,
        ));
    }

    private function __clone() {
        
    }

    public static function getInstance() {
        if(! self::$instance) {
            self::$instance = new facebookFactory();
        }

        return self::$instance;
    }

    public function getFacebook() {
        return $this->facebook;
    }

}
?>
