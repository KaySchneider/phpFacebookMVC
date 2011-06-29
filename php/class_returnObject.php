<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Hier wird die Rückgabe aller Klassen vereinheitlicht!
 */
class returnObject {
    
    private $returnCode = array();

    public function returnError($msg, $int) {
        return array(
                    'type'=>'ERROR',
                    'message'=>$msg,
                    'code'=>$int
                    );
    }

    /**
     *Alle Methoden Rückgaben werden hier vereinheitlicht!
     * @param string $msg nachricht welche ausgibt, eigentlich unwichtig
     * @param array $dataSet wenn Vorhanden dann ein array etc, hier einschieben!
     */
    public function returnSuccess($msg, $dataSet=FALSE) {
        return array(
                    'type'=>'SUCCESS',
                    'message'=>$msg,
                    'data'=>$dataSet
        );
    }


}
?>
