<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class eventDispatcher {
    static private $instance;
    private $handler = array();

    static public function getInstance() {
        if(self::$instance === null) {
            self::$instance = new eventDispatcher();
        }
        return self::$instance;
    }

    public function addHandler($eventName ,eventHandler $handler) {
        if(!isset($this->handler[$eventName])) {
            $this->handler[$eventName] = array();
        }
        $this->handler[$eventName][] = $handler;
    }

    public function triggerEvent($event, $context = null, $info = null) {
        if(! $event instanceof  event) {
            $event = new event($event, $context, $info);
        }
        $eventName = $event->getName();
        if(!isset($this->handler[$eventName])) {
            return $event;
        }
        foreach($this->handler[$eventName] as $handler) {
            $handler->handleEvent($event);
            if($event->isChancelled()) {
                break;
            }
        }
        return $event;
    }

    protected function __clone() {
        
    }

    protected function  __construct() {
        
    }
}
?>
