<?php
    class config {
        public static function connect(){
            $host = "localhost";
            $usernmae = "root";
            $password = "";
            $dbname = "barcode_project";
            try {
                $con = new PDO("mysql:host=$host;dbname=$dbname", $usernmae, $password);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }
            catch(PDOException $e){
                echo "Connection Failed". $e->getMessage();
            }

            return $con;
        }
    }
?>