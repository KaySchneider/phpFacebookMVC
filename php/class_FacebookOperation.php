<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * wrapper for the facebook Object,
 * so that we can develop rapid an facebook application
*/
class FacebookOperation {
    private $facebook;
    private $user;
    private $accessToken;
    public function __construct(Facebook $facebook) {
        $this->facebook = $facebook;
        $this->accessToken = $this->facebook->getAccessToken();
    }

    public function checkLoginState() {
        $session = $this->facebook->getSession();
        return $session;
    }

    public function loginFacebookUser($reg_perms) {
        $params = array(
                'fbconnect' => 0,
                'canvas'    => 1,
                'req_perms' => $reg_perms,
        );
        $loginUrl = $this->facebook->getLoginUrl($params); // URL zum Autorisierungsdialog erstellen.
        return $loginUrl;
    }

    //returns the likes from the current user
    public function get_myLikes() {
        try {
            $me = $this->facebook->api('/me/likes?access_token='.$this->facebook->getAccessToken());
            return $me;
        } catch (FacebookApiException $e) {
            $e;
            return false;
        }
    }
    //returns the likes from an friend of the current user, note: you need extendes rights
    public function get_userLikes($userId) {
        try {
            $me = $this->facebook->api('/'.$userId.'/likes?access_token='.$this->facebook->getAccessToken());
            return $me;
        } catch (FacebookApiException $e) {
            $e;
            return false;
        }
    }

    public function createEvent($arguments, $pid) {
         try {
            $me = $this->facebook->api('/'.$pid.'/events?access_token='.$this->facebook->getAccessToken(),'post', $arguments);
            return $me;
        } catch (FacebookApiException $e) {
            $e;
            return false;
        }
    }

    public function getFB_userId() {
        try {
            $uid = $this->facebook->getUser();
            return $uid;
            //$me = $this->facebook->api('/me');
        } catch (FacebookApiException $e) {
            $e;
            return false;
        }

    }

    public function getMe() {
        try {
            // $uid = $this->facebook->getUser();

            $me = $this->facebook->api('/me');
            return $me;
        } catch (FacebookApiException $e) {
            $e;
            return false;
        }
    }

    public function getUser($userId) {
        try {
            $user = $this->facebook->api('/'.$userId);
            return $user;
        } catch(FacebookApiException $e) {
            $e;
            return false;
        }
    }
    public function getUserOff($userId) {
        try {
            $user = $this->facebook->api('/'.$userId.'?access_token='.$this->facebook->getAccessToken());
            return $user;
        } catch(FacebookApiException $e) {
            $e;
            return false;
        }
    }
    public function getUserPic($userID) {
        return "https://graph.facebook.com/".$userID."/picture";

    }
    public function getPreviewPic($userID) {
        return "https://graph.facebook.com/".$userID."/picture?access_token=".$this->facebook->getAccessToken();
    }

    public function getFqlPreviewPic($fqlPicId) {
       $pic = $this->fql('SELECT src_small FROM photo WHERE aid ="'.$fqlPicId.'"');
       return $pic['src_small'];
    }

    public function postUserFeed($userId,$arguments) {
        try {
            $this->facebook->api("/{$userId}/feed?access_token=".$this->facebook->getAccessToken(), 'post', $arguments);
        } catch(FacebookApiException $e) {
            $e;
            var_dump($e);
            return false;
        }
    }

    public function postUserWall($userId,$arguments) {
        try {
            $this->facebook->api("/{$userId}/feed?access_token=".$this->facebook->getAccessToken(), 'post', $arguments);
        } catch(FacebookApiException $e) {
            $e;
            return false;
        }
    }

    public function getUserFriends() {
        try {

            $friends = $this->facebook->api('/me/friends?access_token='.$this->facebook->getAccessToken());
            return $friends;
        }catch(FacebookApiException $e) {
            $e;
            return false;
        }
    }

    public function getFBLikesData($id) {
        try {

            $fbLikes = $this->facebook->api('/'.$id . '/?access_token='.$this->facebook->getAccessToken());
            return $fbLikes;
        }catch(FacebookApiException $e) {
            $e;
            return false;
        }
    }

    /**
     *
     * @param integer $id
     * @param string $params
     * @return <type>
     */
    public function getLivePlacesData($id) {
       //&latitude=48.8063606&longitude=9.0120328
       try {
            $fbLikes = $this->facebook->api('/'.$id . '/feed?access_token='.$this->facebook->getAccessToken());
            return $fbLikes;
        }catch(FacebookApiException $e) {
            $e;
            return  $e;
        }
    }

    public function createAlbum($userId,$arguments) {
        try {

            $albId = $this->facebook->api('/'.$userId.'/albums?access_token='.$this->facebook->getAccessToken(),'post', $arguments);
            return $albId;
        }catch(FacebookApiException $e) {
            $e;
            return false;
        }
    }
    

    public function getAlbum($userId) {
        try {
            /*
             * fql
             */
            $alb = $this->fql('SELECT aid, cover_pid , name,object_id FROM album WHERE owner = me() OR owner IN (SELECT uid2 FROM friend WHERE uid1= me()) ORDER BY created DESC');
            $fbLikes = $this->facebook->api('/'.$userId.'/albums?access_token='.$this->facebook->getAccessToken());
            return array($fbLikes, $alb);
        }catch(FacebookApiException $e) {
            $e;
            var_dump($e);
            return false;
        }
    }
    /**
     * this mehtod must be used when we want to make
     * an graph call with the id from an album!
     * @param <type> $userId
     * @return <type> array data from facebook
     */
    public function getGraphAlbum($userId) {
        try {
            $fbLikes = $this->facebook->api('/'.$userId.'/albums?access_token='.$this->facebook->getAccessToken());
            return $fbLikes;
        }catch(FacebookApiException $e) {
            $e;
            var_dump($e);
            return false;
        }
    }

    public function getAllAlbumPictures($albId) {
        try {

            $fbLikes = $this->facebook->api('/'.$albId.'/photos?access_token='.$this->facebook->getAccessToken());
            return $fbLikes;
        }catch(FacebookApiException $e) {
            $e;
            //var_dump($e);
            return false;
        }
    }


    public function uploadPhoto($albId,$arguments) {
        //https://graph.facebook.com/me/photos
        try {

            $fbLikes = $this->facebook->api('/'.$albId.'/photos?access_token='.$this->facebook->getAccessToken(),'post', $arguments);
            return $fbLikes;
        }catch(FacebookApiException $e) {
            $e;
             var_dump($e);
            return false;
        }
    }

    /**
     * This Method calls all the Album from the users an call all Pictures from the
     * given Album Name! This is important to call before you call the addTag Photo
     * because this is the old REST API!
     * @param <type> $userId
     * @param <type> $albumName
     * @return <type>
     */
    public function getRestPhotoId($userId,$albumName) {
        try {
            $arguments = array('method'=>'photos.getAlbums',
                    'uid'=>$userId
            );
            $fbLikes = $this->facebook->api($arguments);
            foreach($fbLikes as $album) {

                if($album['name'] == $albumName) {
                    $myAlbId = $album['aid'];
                }
            }
            if(!isset($myAlbId))
                return FALSE;
            $arguments = array('method'=>'photos.get',
                    'aid'=>$myAlbId
            );
            $fbLikes = $this->facebook->api($arguments);
            $anz = count($fbLikes);
            var_dump($anz,$fbLikes[$anz-1]['pid']);
            if(isset($fbLikes[$anz-1]['pid']))
                return $fbLikes[$anz-1]['pid'];
            else
                return FALSE;
            //var_dump($fbLikes[$anz-1]['pid']);
            //return $fbLikes;
        }catch(FacebookApiException $e) {
            $e;
            // var_dump($e);
            return false;
        }
    }

    public function addTagPhoto($pid,$userId,$albId, $arguments) {
        try {
            $x=0;
            $y=0;
            foreach($userId as $id) {
                $tags[] = array('tag_uid'=>$id, 'x'=>$x,'y'=>$y);
                $x+=10;
                $y+=10;
            }
            $tags = json_encode($tags);
            //$json = 'https://api.facebook.com/method/photos.addTag?pid='.$pid.'&tag_uid='.$userId.'&x=50&y=50&access_token='.$this->facebook->getAccessToken();
            $json = 'https://api.facebook.com/method/photos.addTag?pid='.$pid.'&tags='.$tags.'&access_token='.$this->facebook->getAccessToken();
            //var_dump($json);
            $ch = curl_init();
            $url = $json;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_GET, true);
            $data = curl_exec($ch);




        } catch(FacebookApiException $e) {
            echo "Error:" . print_r($e, true);
        }
    }

    /**
     * Integration of FB Places;)
     */
    public function getCheckins($id) {
         try {
//?access_token='.$this->facebook->getAccessToken()
            $fbLikes = $this->facebook->api('/'.$id.'/checkins?access_token='.$this->facebook->getAccessToken());
            return $fbLikes;
        }catch(FacebookApiException $e) {
            $e;
            //var_dump($e);
            return false;
        }
    }

    public function checkinUser($place_id, $arguments) {
       try{
          $checkin = $this->facebook->api('/me/checkins?access_token='.$this->facebook->getAccessToken(), 'post', $arguments);
          return $checkin;
       }catch(FacebookApiException $e ) {
          var_dump($e);
          return FALSE;
       }
    }
    public function fql($query) {
          try {
            $arguments= array(
                        'method'=>'fql.query',
                        'query'=>$query,
                        'access_token'=>$this->facebook->getAccessToken()
                    );
            $fbLikes = $this->facebook->api($arguments);
            return $fbLikes;
        }catch(FacebookApiException $e) {
            $e;
            // var_dump($e);
            return $e;
        }
    }

    public function search($searchField) {
       try {
            //search?type=checkin
          $searchResult = $this->facebook->api('/search?type='.$searchField.'&access_token='.$this->facebook->getAccessToken());
          return $searchResult;
       }
       catch(FacebookApiException $e) {
          e;
          return FALSE;
       }
    }
}
?>
