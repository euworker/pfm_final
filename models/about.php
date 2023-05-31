<?php 


//  здесь собраны все страницы не имеющие отдельной логики
class About {

    private $connect;
        

    public function __construct(){

        $this->connect = DB::getConnection();

    }


    public function getAbout() {
        
    }


    



    
}