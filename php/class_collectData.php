<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class collectData {
    
    private $facebookOperation;
    private $db;

    public $friends;

    public function __construct(FacebookOperation $fbWorker) {
        $this->facebookOperation = $fbWorker;
        $this->friends = $this->getUserFriends();
        $this->me = $this->facebookOperation->getFB_userId();
        $this->db = ATdb::get_instance();
    }

    /**
     * Holt alle likes von allen Freunden ab!
     * Ist relativ Zeitintensiv.... aber es führt leider kein Weg dran vorbei!
     * Mittels Ajax request kann man es für den Nutzer erträglicher machen
     */
    public function startCollectLikes() {
        if(is_array($this->friends['data'])) {
        /*Starten erstmal mit 10 Freunden.
         * Wird dann später erweitert so dass man jeweils um eine Runde weiterspringen kann
         * Und im dritten Step wird das ganze dann dahin verfeinert dass die Anwendung alles
         * in der Datenbank Speichert und mit jeder Runde bessere Ergebnisse liefern kann!
         * So macht das dem Nutzer mehr Spass! Hoffe ich doch.
         * Im letzten Step werden dann alle Nutzer gespeichert und per cron nachts abgefragt
         * sind alle Freunde geholt so wird der Nutzer wieder Informiert  dass nun noch bessere
         * Ergebnisse vorliegen
         */
            $counter = 10;
            $z = 0;
            $listCounter = 0;
            $maxFriend = count($this->friends['data']);
            foreach($this->friends['data'] as $friend) {
                $this->insertUser($friend['id']);
                //Collecte alle interesst from all the Friends!
                $start = true;
                $listCounter++;
                $zufallswähler = mt_rand(0, 10);
               if($zufallswähler == 3)
                    $start = true;
                if(($listCounter+10)>= $maxFriend) {
                    $start = true;
                    print "true";
                }
                if($start == true) {
                    if($z < $counter) {
                        $tmpLike = $this->facebookOperation->get_userLikes($friend['id']);
                        if(isset($tmpLike['data'][0]['name'])) {
                            //$friendsLikes[$friend['id']] = $tmpLike['data'];
                            $friendsLikes["{$friend['id']}"] = array();
                            foreach($tmpLike['data'] as $likesData)  {
                                $this->insertLikeToTable($likesData);
                                $this->insertUserLikes($friend['id'], $likesData['id']);
                                //var_dump($tmpLike['data'], $likesData['id']);die();
                                $userLikes["{$likesData['name']}"] = 1.0;
                                $likesDetail["{$likesData['name']}"] = $likesData;
                            }
                            $friendsLikes["{$friend['id']}"] = $userLikes;
                            unset($userLikes);
                        }
                        //$friendsLikes[$friend['id']] = $this->facebookOperation->get_userLikes($friend['id']);

                    }
                    else
                        break;
                   $z++;
             }
            }//end foreach friends
            //Likes des Akutellen Nutzers dem datenset hinzufügen:
            $tmpLike = $this->facebookOperation->get_myLikes();
                    if(isset($tmpLike['data'][0]['name'])) {
                        //$friendsLikes[$friend['id']] = $tmpLike['data'];
                        $friendsLikes["{$this->me}"] = array();
                        foreach($tmpLike['data'] as $likesData)  {
                            //var_dump($tmpLike['data'], $likesData['id']);die();
                            $userLikes["{$likesData['name']}"] = 1.0;
                            $likesDetail["{$likesData['name']}"] = $likesData;
                        }
                        $friendsLikes["{$this->me}"] = $userLikes;
                        unset($userLikes);
                    }
             //akuteller User ist nun in der Liste
            foreach($friendsLikes as $key=>$ulike ) {
                foreach($likesDetail as $likeId=>$value) {
                   // var_dump(array_merge($friendsLikes[$key], array("{$likeId}"=>0)));die();
                   // var_dump($ulike, $likeId, array_key_exists($likeId, $ulike) ($likeId, $haystack));die();
                    if(!array_key_exists($likeId, $ulike)) {
                        $friendsLikes[$key] = array_merge($friendsLikes[$key], array("{$likeId}"=>0.0));
                    }
                }
            }
            
        }
       // print "<pre>";
       // var_dump($friendsLikes);
       // print "</pre>";
       // die();
        return array($friendsLikes, $likesDetail,$this->me);
    }

    private function checkUserLikes($userId, $likes) {
        $select = 'SELECT * FROM user_likes WHERE user_id="'.$userId.'" AND like_id="'.$likes.'"';
        $this->db->query($select);
        $data = $this->db->get_row();
        if(isset($data['user_id']))
            return TRUE;
        else
            return FALSE;

    }

    private function insertUserLikes($userId, $likes) {
        if($this->checkUserLikes($userId, $likes))
                return FALSE;
        $insert = 'INSERT INTO user_likes (user_id,like_id)
                    values(
                        "'.$userId.'",
                           "'.$likes.'"
                    )
                    ';
        $this->db->query($insert);
    }

    private function insertUser($userId) {
        $insert = 'INSERT INTO user (user_id) values("'.$userId.'")';
        $this->db->query($insert);
    }
    private function insertLikeToTable($likeDetail) {
        $insert = 'INSERT INTO likes (id,name,category) 
                   values("'.$likeDetail['id'].'",
                          "'.mysql_real_escape_string($likeDetail['name']).'",
                          "'.$likeDetail['category'].'"
                    )';
        $this->db->query($insert);
    }

    private function getUserFriends() {
        return $this->facebookOperation->getUserFriends();
    }

    
}
?>
