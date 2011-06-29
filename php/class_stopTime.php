<?php
/* A eaysy and fast way to track the time, your sctipt needs to
 * How to use this small class?
 * make an new instance of it: $timeToProceed = new stopTime(); //now the time is running
 * now you can make things with your script...
 * now you want the time, how long the script duration has teke
 * var_dump($timeToProceed->GetTime()); Now you have the time!
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class stopTime {
    public $zeitmessung1;

    public function __construct() {
       $this->StartTime();
    }

    public function StartTime() {
        $this->zeitmessung1=microtime();
        $zeittemp=explode(" ",$this->zeitmessung1);
        $this->zeitmessung1=$zeittemp[0]+$zeittemp[1];

    }

    public function GetTime() {
        $zeitmessung2=microtime();
        $zeittemp=explode(" ",$zeitmessung2);
        $zeitmessung2=$zeittemp[0]+$zeittemp[1]; // Timestamp + Nanosek
        $zeitmessung=$zeitmessung2-$this->zeitmessung1; // Differenz der beiden Zeiten
        $zeitmessung=substr($zeitmessung,0,8); // es wird auf 6
        return $zeitmessung;
    }
}
?>
