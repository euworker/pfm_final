<?php

// реализация патерна Одиночка

final class  DB {
    // к статическому свойству можно обращаться без создания экземпляра класса 
    private static $connection = null;

    private function __construct(){  
        require_once('configs/db.php');
        $connect = mysqli_connect($db['HOST'],$db['USER'], $db['PASSWORD'], $db['DB_NAME']);
        mysqli_set_charset($connect, $db['CHARSET']);
        // в случае обращения к статическому методу, пишем через  self:: , а не через $this
        self::$connection = $connect;

    }

public static function getConnection() {
    if (self::$connection == null) {
        new self();
    }

    return self::$connection;

    }

    // выключаем все доступные функции

    private function __clone(){
        
    }

    public function __sleep(){

    }

    public function __wakeup() {

    }

}
 

?> 