<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class logException implements log {

    private $db;
    private $reg;
    private static $instance = null;

    private function  __construct() {
        $this->db = ATdb::get_instance();
        $this->reg = registry::getInstance();
    }
    public function userLog($userId,$userip) {
    }

    public function errorLog($className, $methodName, $error) {
        $logQuery = 'INSERT INTO ' . TABLE_LOG
                    . ' (klasse,methode,fehler)'
                    . ' values('
                    .' "' . mysql_real_escape_string($className) . '",'
                    .' "' . mysql_real_escape_string($methodName) . '",'
                    .' "' . mysql_real_escape_string($error) . '"'
                    . ' )'
        ;
        /**
         * Insert in DB with try, because the mysql server is down
         */
        try {
            $this->db->query($logQuery);
        }
        catch(exception $e) {
            //$log=false;
            var_dump($e, mysql_error());
        }
        
    }

    private function __clone() {
        
    }

    public static function getInstance() {
        if(! isset(self::$instance)) {
            self::$instance = new logException();
        }
        return self::$instance;
    }
    
}
?>
