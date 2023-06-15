<?php


//  здесь собраны все страницы не имеющие отдельной логики

class CommonController {

    private $commonModel;
    private $groupModel;
    public $isAuthorized;
    public $menuProducts;

    public function __construct() {
        $this->commonModel = new Common();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        $this->groupModel = new Group();
        // $this->menuProducts = $this-> groupModel->getOneLevelNameGroups();
        global $menuProducts;
        $this->menuProducts = $menuProducts;
        
        
    }


    


}

?>