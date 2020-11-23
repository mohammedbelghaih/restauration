<?php
    class Database{
        private $dsn;
        private $dbname;
        private $dbuser;
        private $pass;
        private $pdo;   
        public $err="";
        public function __construct($dsn="localhost:3308", $dbname="restauration", $dbuser="root", $pass=""){
            $this->dsn= $dsn;
            $this->dbname= $dbname;
            $this->dbuser= $dbuser;
            $this->pass= $pass;
        }
        
        public function getpdo(){
            try{
            $pdo=new PDO('mysql:host=localhost:3308;dbname=restauration','root','');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo= $pdo;
            } catch(EXCEPTION $error){
                echo $error->getMessage();
            }
            return $pdo;
        }

        public function plateOfTheDay(){
            
            $sql=$this->getpdo()->query("select * from menu order by rand(round(to_seconds(now()) / 3600)) limit 1");
            return $sql;
        }
        
    }
?>