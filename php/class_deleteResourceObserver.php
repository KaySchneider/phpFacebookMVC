<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Überwacht die Klasse Anzeige.
 * Sobald eine Anzeige gelöscht wird
 * löscht es alle weiteren Resourcen
 */
class deleteResourceObserver implements Observer {
    public function update(Observable $anzeige) {
        if(!$anzeige instanceof anzeige)
            return FALSE;
        if($anzeige->lastDeleteAffect == 1) {
    
            if(isset($anzeige->anzId)) {
                
      
                $delReserve = new reserve();
                $delReserve->deleteReserveObserver($anzeige->anzId);
            }
        }
    }
}
?>
