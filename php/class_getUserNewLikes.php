<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class getUserNewLikes {
    private $topMatches;
    private $fbWorker;
    public function  __construct($topMatches, FacebookOperation $fbWorker) {
        $this->topMatches = $topMatches;
        $this->fbWorker = $fbWorker;
    }

    public function getUserTopMatches() {
        $userLikes = $this->fbWorker->get_myLikes();
        $userLikes = $this->makeNewLikeAr($userLikes);
        foreach($userLikes as $like=>$value) {

            if(isset($this->topMatches[$like]))
                $returnNewLikes[$like] = $this->topMatches[$like];
        }
        if(!is_array($returnNewLikes))
            return FALSE;
        foreach($returnNewLikes as $key=>$value) {
            foreach($value as $keys=>$v) {
                if(!array_key_exists($keys, $userLikes)) {
                    $returnLikes[$keys] = $v;
                }
            }
            
        }
        return $returnLikes;
    }

    public function makeOutputArray($topMatches,$detailData) {
        foreach($topMatches as $idKey=>$value) {
            if(array_key_exists($idKey, $detailData)) {
                $likePageData[] = $this->fbWorker->getFBLikesData($detailData[$idKey]['id']);
            }
        }
        return $likePageData;
    }


    public function makeNewLikeAr($likes)  {
        foreach($likes['data'] as $liker) {
            $tmpLike[$liker['name']] = 1;
        }
        return $tmpLike;
    }
    //public function userTopMatch($itemPrefs) {
      //  $this->topMatches->topMatch($itemPrefs,,$n);
    //}
}
?>
