<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class calculateSimmilaryItems {
    public $result;
    public $transformator;
    public $topMatches;
    
    public function __construct() {
        $this->transformator = new transformPrefs;
        $this->simmilarity = simFactory::simFact('vektor');
        $this->topMatches = new topMatches($this->simmilarity);

    }

    public function generateSimItems($dataSet,$n=10) {
        //$itemPrefs = $this->transformator->transform($dataSet);
        $itemPrefs = $dataSet;
        $c=0;
        //var_dump($itemPrefs);die();
        foreach($itemPrefs as $item=>$value) {
            $c++;
            //Meldung bei großen Datenmengen ;)
            if(($c%100)==0) print "TET\n\t<br/>";
            //var_dump($item,$value);die();
            $scores = $this->topMatches->topMatch($itemPrefs,$item,$n);
            $this->result["{$item}"]=$scores;
        }
        return $this->result;
    }
}
?>
