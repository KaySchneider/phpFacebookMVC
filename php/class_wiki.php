<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * this small class returns an random title 
 * of an wikipedia article
 */
class wiki {
    private $url;
    private $mode;
    private $lang;
    private $requestMaker;

    public function  __construct($lang='de') {
        $this->lang = $lang;
        $this->url = 'http://'.$this->lang.'.wikipedia.org/w/api.php';
        $this->requestMaker = new Zend_Http_Client();
        $this->requestMaker->setUri($this->url);
        $this->requestMaker->setMethod(Zend_Http_Client::GET);

    }

    public function makeRandomCall() {
        //?action=query&list=random&rnnamespace=0&rnlimit=1
        $this->requestMaker->setParameterGet('action','query');
        $this->requestMaker->setParameterGet('format','json');
        $this->requestMaker->setParameterGet('list','random');
        $this->requestMaker->setParameterGet('rnlimit',1);
        $this->requestMaker->setParameterGet('rnnamespace',0);
        $response = $this->requestMaker->request();
        $data = json_decode($response->getBody());
        //var_dump($data->id, $data->title,$data->query->random[0]->title);
        return $data->query->random[0]->title;
    }
   
}
?>
