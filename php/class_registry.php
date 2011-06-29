<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
class registry {
    protected static $instance = null;
    private $values;
    const KEY_VIEW = 'view';
    const KEY_USER = 'user';
    const KEY_RESPONSE = 'response';
    const KEY_REQUEST = 'request';
    const KEY_CATEG = 'categ';
    const KEY_USERID = 'userID';
    const KEY_ADD_HEADER = 'header';
    const KEY_ADD_DESCRIPTION = 'description';
    const KEY_META_TAG = 'meta';
    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new registry();
        }
        return self::$instance;
    }

    protected  function  __construct() {

    }

    protected function  __clone() {

    }

    protected function set($key,$value) {
        $this->values[$key] = $value;
    }

    protected function get($key) {
        if(isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }

    /**
     * Zur Speicherung eines View Objektes.
     * Hier soll die Hauptview abgelegt werden
     * damit die Commands ihre erzeugten views in
     * den content bereich schreiben können
     * @param render $view
     */
    public function setView(render $view) {
        $this->set(self::KEY_VIEW, $view);
    }

    public function getView() {
        return $this->get(self::KEY_VIEW);
    }

    public function setUser(user $user) {
        $this->set(self::KEY_USER, $user);
    }

    public function getUser() {
        return $this->get(self::KEY_USER);
    }

    public function setResponse(Response $response) {
        $this->set(self::KEY_RESPONSE,$response);
    }

    public function getResponse() {
        return $this->get(self::KEY_RESPONSE);
    }

    public function setRequest(Request $request) {
        return $this->set(self::KEY_REQUEST, $request);
    }

    public function getRequest() {
        return $this->get(self::KEY_REQUEST);
    }

    public function getCateg() {
        return $this->get(self::KEY_CATEG);
    }

    public function setCateg($categ) {
      $oldData = $this->get(self::KEY_CATEG);
      if(is_array($oldData))
          $insertCateg = array_merge($oldData, $categ);
      else
          $insertCateg = $categ;
        $this->set(self::KEY_CATEG, $insertCateg);
    }

    public function setUserAuto(array $userID) {
        $this->set(self::KEY_USERID, $userID);
    }

    public function getUserAuto() {
        return $this->get(self::KEY_USERID);
    }

    public function setHeader($headerString) {
        $this->set(self::KEY_ADD_HEADER,$headerString);
    }

    public function getHeader() {
        return $this->get(self::KEY_ADD_HEADER);
    }

    public function setDescription($description) {
        $this->set(self::KEY_ADD_DESCRIPTION, $description);
    }

    public function getDescription() {
        return $this->get(self::KEY_ADD_DESCRIPTION);
    }

    public function setMetaTag($metaTagsArray) {
        $this->set(self::KEY_META_TAG, $metaTagsArray);
    }

    public function getMetaTag() {
        return $this->get(self::KEY_META_TAG);
    }
}
?>
