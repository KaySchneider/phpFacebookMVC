<?php
/****************************/
//
// Datenbank Klasse
//
/****************************/
class ATdb {

    private $db_connect="";				// Datenbankverbindung offen
    private $db_close="";				// Datenbankverbindung geschlossen
    private $db_select_db="";			// Angabe der Datenbank die connectiert wird
    private $db_query="";				// Datenbankquery
    private $db_fetch_array="";			// Datenarry
    private $db_num_rows="";			// Datenreihen

    private $host;						// Host (meist localhost)
    private $database;					// Name der Datenbank
    private $user;						// Name des connctierten users
    private $password;					// Passwort des connectierten users
    private $port;						// gegebenenfalls der port zum connceten
    private $database_type;				// Datenbank Typ
    private $dsn;

    private $debug=FALSE; 					// debug mode on (true) / off (false)
    private $log=FALSE;

    private $sql;

    private $con; 						// variable for connection id
    var $con_string; 					// variable for connection string
    var $query_id; 						// variable for query id

    var $errors; 						// variable for error messages
    var $error_count=0; 				// variable for counting errors
    var $error_nr;
    var $error;

    /**
     * @desc Constructor for database class
     * @param $database_type
     * @param $host
     * @param $database
     * @param $user the
     * @param $password
     */
    public function __construct($host, $database, $user, $password, $port=false, $dsn=false) {

        $this->host=$host;
        $this->database=$database;
        $this->user=$user;
        $this->password=$password;
        if ($port == '') $this->port = FALSE;
        else $this->port=$port;
        $this->dsn=$dsn;

        // Setting database type and connect to database
        $this->database_type="mysql";

        $this->db_connect=$this->database_type."_connect";
        $this->db_close=$this->database_type."_close";
        $this->db_select_db=$this->database_type."_select_db";

        $this->db_query=$this->database_type."_query";
        $this->db_fetch_array=$this->database_type."_fetch_array";
        $this->db_insert_id=$this->database_type."_insert_id";
        $this->db_affected_rows = $this->database_type."_affected_rows";
        $this->db_num_rows=$this->database_type."_num_rows";

        return $this->connect();
    }


    public static function &get_instance() {
        // Singleton-Pattern
        static $instance;
        if (!is_object($instance)) {
            $instance = new ATdb(DB_HOST , DB_BASE , DB_USER , DB_PASS);
            $instance->connect();
        }
        return $instance;
    }


    /**
     * @desc establishs the connection to the database
     * @return boolean $is_connected Returns true if connection was successful otherwise false
     */
    public function connect() {
        // Selecting connection function and connecting
        if($this->con=='') {
            $this->logError('connect');
            if($this->port !== FALSE) $this->con=call_user_func($this->db_connect,$this->host.":".$this->port,$this->user,$this->password);
            else $this->con=call_user_func($this->db_connect,$this->host,$this->user,$this->password);

            $this->query('SET NAMES utf8');

            if(!$this->con) {
                $this->halt("Wrong connection data! Can't establish connection to host.");
                $this->logError('Wrong connection data! Cant establish connection to host');
                return false;
            } elseif(!call_user_func($this->db_select_db,$this->database,$this->con)) {
                $this->halt("Wrong database data! Can't select database.");
                $this->logError("Wrong database data! Can't select database.");
                return false;
            } else return true;

        } else {
            $this->halt("Already connected to database.");
            $this->logError('attempt to connect while connected');
            return false;
        }
    }


    /**
     * @desc This function queries the database
     * @param string $sql_statement the sql statement
     * @return boolean $successfull returns false on errors otherwise true
     */
    public function query($sql_statement) {
        
        $this->logError('try to query: '.$sql_statement);
        $this->sql=$sql_statement;

        if($this->debug) {
            printf("<br />SQL statement: %s\n\r",$this->sql);
        }


        if(!$this->query_id=call_user_func($this->db_query, $this->sql, $this->con)) {
            $this->halt("No database connection exists or invalid query.");
            $this->logError('No database connection exists');
            return FALSE;
        } else {
            if (!$this->query_id) {
                $this->halt("Invalid SQL Query.");
                $this->logError('invalid query: '.$sql_statement);
                return false;
            } else {
                return true;
            }
        }

    }

    /**
     *Jede Besuchte Seite wird als besucht vermerkt!
     * damit kann später geprüft werden auf welchen Seiten der
     * flohBot schon war, keine doppelt Sichtungen
     * @param <type> $url
     */
    public function insertURLVisited($url) {
        $sql = 'INSERT INTO'
                   . ' ' . TABLE_VISITED
                    . ' (url)'
                    . ' values(
                        "'.$url.'"
                    )'
            ;
        $this->query($sql);
    }
//TABLE_VISITED
    public function hasVisited($link) {
        if(!empty($link)) {
            $query = 'SELECT id'
                     . ' FROM'
                        . ' ' . TABLE_VISITED
                     . ' WHERE'
                        . ' url=\'' . $link . '\''
                    ;
            var_dump($query);
            $this->query($query);
            //return TRUE;
            return $this->get_row();
        }
    }

    public function inDatabase($link) {
        if(!empty($link)) {
            $query = 'SELECT id'
                     . ' FROM'
                        . ' ' . TABLE_EVENT
                     . ' WHERE'
                        . ' `url`="' . $link . '"'
                    ;
            $this->query($query);
            return $this->get_row();
        }
    }
    public function insertURL($url, $mod) {
        //stripslashes($url[0]);
        if(!$this->inDatabase($url)) {
            $sql = 'INSERT INTO'
                       . ' ' . TABLE_EVENT
                        . ' (`url`, `mod`)'
                        . ' values(
                            "'.$url.'",
                            "'.$mod.'"
                        )'
                ;
        }
        
        $this->query($sql);
    }

    /**
     * gibt alles aus dem TMP DB Speicher zurück!!
     */
    public function getTMP($del = TRUE) {
        $query = 'SELECT `url` FROM ' . TABLE_TEMP_LINK;
        $this->query($query);
        var_dump( $query);
        $data = $this->get_rows();
        if($del == TRUE) {
            $query = 'TRUNCATE TABLE ' . TABLE_TEMP_LINK;
            $this->query($query);
            //var_dump($query);print mysql_error();die();
        }
        return $data;
    }

    public function insertTMP($urlList) {
        //stripslashes($url[0]);
        if(! is_array($urlList))
            return FALSE;
        foreach($urlList as $url ) {
            if(!$this->inDatabase($url)) {
                $sql = 'INSERT INTO'
                           . ' ' . TABLE_TEMP_LINK
                            . ' (`url`)'
                            . ' values(
                                "'.$url.'"
                            )'
                    ;
                $this->query($sql);
            }
            //var_dump($sql);
            
        }
    }
    /**
     * @desc This function returns a row of the resultset
     * @return array $row the row as array or false if there is no more row
     */
    public function get_row() {
        //var_dump($this->query_id);
        if( is_resource($this->query_id) ) {
            $row=call_user_func($this->db_fetch_array,$this->query_id,MYSQL_ASSOC);
            return $row;
        }
        else
            return FALSE;
    }


    public function get_rows() {
        while ($row = $this->get_row()) {
            $rows[] = $row;
        }

        if (!empty($rows)) return $rows;
        else return FALSE;
    }


    public function get_resource($query) {
        $this->logError('No database connection exists');
        return mysql_query($query, $this->con);
    }


    public function found_rows() {
        $this->logError('found rows attempt');

        $this->query_id = call_user_func($this->db_query, 'SELECT FOUND_ROWS();', $this->con);
        return $this->get_row();

        //$result = mysql_query('SELECT FOUND_ROWS();');
        //return mysql_fetch_row($result);

    }

    /**
     * @desc This function returns number of rows in the resultset
     * @return int $row_count the nuber of rows in the resultset
     */
    public function count_rows() {

        if( is_resource($this->query_id)) {
            $row_count=call_user_func($this->db_num_rows,$this->query_id);
            if($row_count>=0) {
                return $row_count;
            } else {
                //$this->halt("Can't count rows before query was made");
                return false;
            }
        }
        else
           return false; //$this->halt("Can't count rows, there was an error with the query");
        return false;
    }


    /**
     * @desc This function returns all tables of the database in an array
     * @return array $tables all tables of the database in an array
     */
    public function get_tables() {
        $tables = "";
        $sql="SHOW TABLES";
        $this->query($sql);
        for($i=0;$data=$this->get_row();$i++) {
            $tables[$i]=$data['Tables_in_'.$this->database];
        }
        return $tables;
    }


    /**
     * @desc Show Last Index
     */
    public function last_insert() {
        return call_user_func($this->db_insert_id);
    }


    /**
     * @desc Show affected rows
     */
    public function last_affect() {
        return call_user_func($this->db_affected_rows);
    }

    /**
     * @desc Returns all occurred errors
     * @param string $message all occurred errors as array
     */
    private function halt($message) {
        if($this->debug) {
            printf("Database error: %s\n", $message);
            if($this->error_nr!="" && $this->error!="") {
                printf("MySQL Error: %s (%s)\n",$this->error_nr,$this->error);
            }
            die ("Session halted.");
        }
    }


    /**
     * @desc Switches to debug mode
     * @param boolean $switch
     */
    public function debug_mode($debug=true) {
        $this->debug=$debug;
    }


    public function log_mode($log=TRUE) {
        $this->log = $log;
    }

    public function __get($key) {
        if (isset($this->$key)) {
            if (is_array($this->$key)) {
                return (array) $this->$key;
            }
            return $this->$key;
            //return $this->$value;
        }
    }

    private function logError($message) {
        if ($this->log) {
            $f = fopen(GLOBAL_LOG_PATH.'/rightsManagement.log', 'a');
            if ($f) {
                fwrite($f, date("Y-m-d H:i:s")." \t$message\n\r\n\r");
                fclose($f);
            }
        }
    }
}
?>