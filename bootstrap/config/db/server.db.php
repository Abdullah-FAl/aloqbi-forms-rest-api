<?php

$_ENV["tokenapi"]="supersecretkeyyoushouldnotcommittogithub";
$_ENV["appname"]='altaqyim';


 class dbConnect {
        // Properties
        private $dbhost = 'localhost:3306';
        private $dbuser = 'aloqbico_altaq2';
        private $dbpass = 'ORdASUiu5Xo';
        private $dbname = 'aloqbico_altaqyim';
         

        // Connect
        public function connect(){
            $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname";'charset=utf8';
            $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
             $dbConnection-> exec("SET CHARACTER SET utf8");
            return $dbConnection;
        }
 
}













