<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class getFacebookRights implements eventHandler {

    /**
     * Diese Klasse loggt alle vorkommnisse welche
     * irgendwo im System geworfen werden
     * Speichert alles Atomar in einer DB mit möglichst präziser beschreibung, arrays werden mit foreach durchlaufen und
     * als TEXT in die Datenbank geworfen!
     * DB hat drei Felder -> Klasse in der es passiert ist und Methode und ein Feld mit einem beliebigen Datenwert
     * @param event $event
     */
    public function handleEvent(event $event) {
        /**
         * Unterbrucht die Ausgabe und beginnt und verlink auf FB Rechte holen!
         */
        $reg = registry::getInstance();
        $response = $reg->getResponse();
        $facebook = facebookFactory::getInstance();
        $fbObject = $facebook->getFacebook();
        $fbWorker = new FacebookOperation($fbObject);

        $redirectUrl = $fbWorker->loginFacebookUser(FACEBOOK_REG_PERMS);

        $response->write('<script>top.location.href = "' . $redirectUrl . '"</script>');
        $response->flush();
    }
}
?>