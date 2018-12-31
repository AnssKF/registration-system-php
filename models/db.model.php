<?php

class Db {

    protected static $connection = null;

    public static function connect(){

        if( Db::$connection != null ){
            return;
        }

        try{
            Db::$connection = new PDO('mysql:host='. Config::DATABASE['host'] .';dbname='. Config::DATABASE['name'] .';', Config::DATABASE['username'] , Config::DATABASE['password']);
            Db::$connection->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function runQuery($query,$values = []){
        if( Db::$connection != null ){
            $stmt = Db::$connection->prepare($query);
            $stmt->execute($values);
            return $stmt;
        }else {
            return null;
        }
    }
    
}