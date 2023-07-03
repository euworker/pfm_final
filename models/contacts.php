<?php 


//  здесь собраны все страницы не имеющие отдельной логики
class Contacts {

    private $connect;
        

    public function __construct(){

        $this->connect = DB::getConnection();

    }

}