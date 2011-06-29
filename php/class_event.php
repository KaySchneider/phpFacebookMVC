<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 * Das Event Objekt! Besitzt eine Methode um das UserObjekt hinzuzufügen!
 */
class event {
    private $name;
    private $context;
    private $info;
    private $chancelled = false;
    private $user;

    public function __construct($name, $context = null, $info = null) {
        $this->name = $name;
        $this->context = $context;
        $this->info = $info;
    }

    public function getName() {
        return $this->name;
    }

    public function getContext() {
        return $this->context;
    }

    public function getInfo() {
        return $this->info;
    }

    public function isChancelled() {
        return $this->chancelled;
    }

    public function cancel() {
        $this->chancelled = true;
    }

    public function setUser(user $user) {
        $this->user = $user;
    }

    public function getUser() {
        if(isset($this->user) && $this->user instanceof user)
            return $this->user;
        else
            return null;
    }

    
}
?>
