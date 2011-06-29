<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 * Diese Klasse beinhaltet alle Methoden welche zur Sicherheit der Nutzereingaben
 * dienlich sind.
 * Vorrangig erstmal die Methoden welche die Prüfung der Ausgangsdaten beinhalten
 */
class secInput {

    public function checkPost($data) {
        foreach($data as $key => $value) {
            if(is_array($data[$key]))
                $newData[$key] = self::checkPost($data[$key]);
            else
                $newData[$key] = $this->checkOne($value);
        }

        return $newData;
    }

    private function checkOne($value) {
        return htmlentities($value, ENT_QUOTES, 'utf-8');
    }
}
?>
