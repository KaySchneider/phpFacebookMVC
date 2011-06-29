<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class exceptionLogger implements eventHandler {

    /**
     * Diese Klasse loggt alle vorkommnisse welche
     * irgendwo im System geworfen werden
     * Speichert alles Atomar in einer DB mit möglichst präziser beschreibung, arrays werden mit foreach durchlaufen und
     * als TEXT in die Datenbank geworfen!
     * DB hat drei Felder -> Klasse in der es passiert ist und Methode und ein Feld mit einem beliebigen Datenwert
     * @param event $event
     */
    public function handleEvent(event $event) {
        $data = $event->getInfo();
        $className = $data['className'];
        $methodName = $data['methodName'];
        $error = $data['error'];
        $errorLogger = errorLog::getErrorLogger();
        $errorLogger->errorLog($className, $methodName, $error);
    }
}
?>
