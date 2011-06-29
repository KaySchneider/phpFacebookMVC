<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
class uploadFBCommand implements command {
    public function execute(Request $request, Response $response) {
        $req = registry::getInstance();
        $renderEngine = $req->getView();
        $renderOverview = new render('makeBand');
        //FileName aus der Session auslesen! Wenn nicht gesetzt Fehlermeldung

        if(isset($_SESSION['image'])) {

            $imageName = $_SESSION['image'];
            $band = $_SESSION['band'];
            $title = $_SESSION['title'];
            //Hole Facebook Factory
            $facebook = facebookFactory::getInstance();
            $fbObject = $facebook->getFacebook();
            $fbWorker = new FacebookOperation($fbObject);
            $this->fbWorker=$fbWorker;
            $userId = $this->fbWorker->getFB_userId();

            $userAlbums = $this->fbWorker->getAlbum($userId);
            $theMaker = 'TheBandMaker';
            foreach($userAlbums['data'] as $album) {
                // var_dump($album);die();
                if($album['name'] == $theMaker) {
                    $dataMaker = $album;
                }
            }
            if(!isset($dataMaker))
                $dataMaker = $this->makeAlbum();
            //Album erstellen
            //
            //   var_dump($dataMaker);
            //fopen(BASEPATH.'/tmp/'$imageName, 'r');

            //TESTABSCHNITT ALLES VERÖFFENTLICHEN
            $fbObject->setFileUploadSupport(true);
            try {
                $arguments = array(
                        'message' => 'The Band: '.$band.' with the First Album: '.$title.'! Created by the http://apps.facebook.com/givemelike/?mode=makeBand The BandMaker erstellt auch deine Band! Mit Namen, CD Cover ;) Das rundum sorglos Paket! The Band Maker..... Macht mit Wikipedia und Flickr deine Band!',
                        'tags'=>$this->makeTagArray($this->getRandomFriends($userId)),
                        'source' => '@' .realpath( BASEPATH . '/tmp/'.$imageName),
                );
                //  $arguments['image'] = '@' .realpath( BASEPATH . '/tmp/'.$imageName);
                //  var_dump($arguments);
                $userId = $this->fbWorker->getFB_userId();
                $picId = $this->fbWorker->uploadPhoto($dataMaker['id'],$arguments);

            }catch(Exception $e) {//Wenn Fehler dann onException Event triggern!

                eventDispatcher::getInstance()->triggerEvent('onException', 'phpMailerNeueAnzeigeFB', array('className'=>'NeueAnzeigeMail', 'methodName'=>'HanldeEvent','error'=>'Mail konnte nicht versendet werden' . $e));
            }
            //Add Tag To the
            //'tags' => array('tag_uid'=>$userId,'x'=>10,'y'=>10,'tag_text'=>'the FUCKING BAND'),
            //TAgs werden im zweiten Schritt hinzugefügt
            $fbObject->setFileUploadSupport(false);
           
            $renderOverview->assign('uploadSuc' , 'Hochgeladen');
            $renderOverview->assign('coverUrl2' , $imageName);
            $renderOverview->assign('band' , $band);
            $renderOverview->assign('title' , $title);
            $renderOverview->renderView();
            $renderEngine->assign('content',$renderOverview->getHtml());
        }
    }
    private function getRandomFriends($userId) {
        $friends = $this->fbWorker->getUserFriends();
        $max = count($friends['data'])-1;
        $one = $friends['data'][mt_rand(1, $max)]['id'];
        $two = $friends['data'][mt_rand(1, $max)]['id'];
     
        return array($userId,$one,$two);
    }

    private function makeTagArray($userId) {
        foreach($userId as $id) {
              $tags[] = array('tag_uid'=>$id, 'x'=>$x,'y'=>$y);
              $x+=10;
              $y+=10;
          }
        $tags = json_encode($tags);
        return $tags;
    }
    private function makeAlbum() {
        $userId = $this->fbWorker->getFB_userId();
        try {
            $arguments = array(
                    'name'=>'TheBandMaker'
            );

            return $this->fbWorker->createAlbum($userId,$arguments);
        }catch(Exception $e) {//Wenn Fehler dann onException Event triggern!
            // var_dump($e);
            // eventDispatcher::getInstance()->triggerEvent('onException', 'phpMailerNeueAnzeigeFB', array('className'=>'NeueAnzeigeMail', 'methodName'=>'HanldeEvent','error'=>'Mail konnte nicht versendet werden' . $e));
        }

    }

}
?>
