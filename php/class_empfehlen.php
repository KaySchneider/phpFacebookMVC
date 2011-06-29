<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class empfehlen {
    private $totals;
    private $simSums;
    private $me;
    private $db;

    /**
     * Erstellt eine Empfehlung für eine Person her
     * Beschränkung auf die Top 10
     */
    public function getEmpfehlung($kritiken, $person,simmilarity $simClass) {
        $this->me = $person;
        $this->db = ATdb::get_instance();
        foreach($kritiken as $other=>$value) {
            if($other == $person)
                continue;
            $sim = $simClass->makeSim($kritiken, $person, $other);

            //Werte  <= 0 ignorieren
            if($sim<=0) continue;
            //var_dump($other);
            foreach($value as $film => $bewert) {
                    //Nur Filme Bewerten welche $person noch nicht bewertet hat!
                    if(!key_exists($film, $kritiken[$person]) || $kritiken[$person]==0 || $kritiken[$person][$film]==0) {
                        $this->totals[$film] +=  ($bewert*$sim);
                        $this->simSums[$film] +=$sim;
                    }
                   
            }
        }

        foreach($this->totals as $item => $value) {
            $rankings[$item] = ($value/$this->simSums[$item]);
            
        }

        arsort($rankings);
        //return array_slice($scores ,0,$anzahlReturn);
        $return = array_slice($rankings,0,10);
        foreach($return as $item=>$value) {
            $this->saveUserScores($item, $value);
        }
        return $return;
        
    }

    private function getLikeId($likeName) {
        $select = 'SELECT * FROM likes WHERE name="'.mysql_real_escape_string($likeName).'"';
        $this->db->query($select);
        $data = $this->db->get_row();
        if(isset($data['id']))
            return $data['id'];
        else
            return FALSE;
    }

    private function scoreExists($likeId) {
        
        $select = 'SELECT * FROM user_score WHERE like_id="'.$likeId.'" AND user_id="'.$this->me.'"';
        $this->db->query($select);
        $data = $this->db->get_row();
        if(isset($data['user_id']))
            return TRUE;
        else
            return FALSE;
    }

    private function saveUserScores( $likeId, $scores) {
        $likeId = $this->getLikeId($likeId);
        if($this->scoreExists($likeId))
            $insert = 'UPDATE user_score set score='.$scores.' WHERE like_id="'.$likeId.'" AND user_id="'.$this->me.'" ';
        else
            $insert = 'INSERT INTO user_score (like_id, user_id,score)
                       values(
                            "'.$likeId.'",
                            "'.$this->me.'",
                               '.$scores.'
                        )
                        ';
        $this->db->query($insert);
        print mysql_error();
    }
}


?>
