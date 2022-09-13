<?php
    /*
     * Author Owen Kalungwe
     * 16-07-2019
     * Last updated: null
     * Mostly used Mysql function
    */
    class mysql{

        public $host,$user,$password,$database;
        public static $obj,$query,$committed;
        private static $sqlQuery;

        function connect(){
            $con = @mysqli_connect($this->host,
                $this->user,
                $this->password,
                $this->database
            );
            if($con) return $this->setConnection($con);
            return false;
        }

        private function setConnection($mysql){
            return (self::$obj=$mysql);
        }

        static function getError(){
            return @mysqli_error(self::$obj);
        }

        static function query($query=false){
            if(empty($query)){
                $query = self::$query;
                self::$query="";
            }
            self::$sqlQuery="";
            return @mysqli_query(self::$obj,$query);
        }

        static function directFetch($query=false){
            $resultSet = self::query($query);
            if(self::rows($resultSet)>0){
                return self::fetch($resultSet);
            }
            return false;
        }

        static function fetch($resultSet,$getNumKeys=false,$getObj=false){
            if($getObj){
                return @mysqli_fetch_object($resultSet);
            }
            $array = @mysqli_fetch_array($resultSet);
            if($getNumKeys) return $array;
            if(is_array($array)) {
                if (count($array) > 0) {
                    foreach ($array as $k => $v) {
                        if (!is_numeric($k)) {
                            if ($k != '0') $newArr[$k] = $v;
                        }
                    }
                    return $newArr;
                }
            }
            return $array;
        }

        static function clean($string){
            return @mysqli_real_escape_string(self::$obj,$string);
        }

        static function buildInsertQuery($array,$table){
            if(!is_array($array)) return false;
            $bA="("; $bC=")";
            foreach($array as $key => $value){
                if(is_array($value)){
                    $bA=""; $bC="";
                    foreach($value as $k => $v){
                        if(is_array($v))return false;
                        if (self::$obj) {
                            $k = self::clean($k);
                            $v = self::clean($v);
                        }
                        $sql_keys[$k]   = $k; // get database values
                        $sql_values[$k] = "'" . $v . "'"; // get database values
                    }
                    $sql_value[] = '('.@implode(',',$sql_values).')';
                }else {
                    if (self::$obj) {
                        $key   = self::clean($key);
                        $value = self::clean($value);
                    }
                    $sql_keys[]  = $key; // get database values
                    $sql_value[] = "'" . $value . "'"; // get database values
                }
            }
            $query = "INSERT INTO ".$table."(".@implode(',',$sql_keys).") VALUES {$bA}
				".@implode(',',$sql_value)."
			{$bC}";
            self::$sqlQuery = $query;
            return $query;
        }

        static function commit(){
            if(self::query(self::$sqlQuery)){
                self::$committed=true;
            }
            else{
                self::$committed=false;
            }
            return self::$committed;
        }

        static function buildUpdateQuery($array,$array_where,$table,$limit=1){
            $operator = false;
            $query = "UPDATE ".$table." SET".PHP_EOL;
            $count = 1;
            foreach($array as $key => $value){
                $x = $count++;
                if(self::$obj){
                    $key 	= self::clean($key);
                    $value 	= self::clean($value);
                }
                $comma = ',';
                if($x  == count($array)){
                    $comma = NULL;
                }
                $query .= "".$key." = '".$value."'".$comma."".PHP_EOL;
            }
            $count  = 1;
            $query .= "WHERE ";
            foreach($array_where as $key => $value){
                $x = $count++;
                if(self::$obj){
                    $key 	= self::clean($key);
                    $value 	= self::clean($value);
                }
                if(!$operator){
                    $and = ' AND ';
                }
                if($x == count($array_where)){
                    $and = NULL;
                }
                $query .= "".$key." = '".$value."' ".$and." ";
            }
            if($limit!=false){
                if($limit){
                    PHP_EOL.$query .= "LIMIT ".$limit;
                }
            }
            self::$sqlQuery = $query;
            return $query;
        }

        public static function delete($field,$value,$table,$limit=1,$extras=false){
            $ExtraGlue ='';
            if(is_array($extras)){
                foreach($extras as $k => $v){
                    $ExtraGlue .= " AND ".$k." = '".$v."'";
                }
            }
            $q = self::getQuery("
				DELETE FROM ".$table." 
				WHERE ".$field." = '".$value."' ".$ExtraGlue." LIMIT ".$limit."
			");
            self::query($q);
            if(self::affectedRows()>0){
                return true;
            }
            return false;
        }

        public static function affectedRows(){
            return @mysqli_affected_rows(self::$obj);
        }

        public static function getLastId(){
            return @mysqli_insert_id(self::$obj);
        }

        public static function getQuery($sql){
            return $sql;
        }

        public static function rows($mysqlObj){
            return @mysqli_num_rows($mysqlObj);
        }
    }

    $mysql = new mysql;
    $mysql->database = "";
    $mysql->host="";
    $mysql->user="";
    $mysql->password="";
    
    if(!$mysql->connect()){
        exit(json_encode(
			array(
				'type'=>'danger',
				'msg'=>"Database connection failed"
			)
		));
    }