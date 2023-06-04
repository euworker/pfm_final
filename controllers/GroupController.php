<?php

//  require_once("models/manufacturer.php");

class GroupController {

    private $groupModel;
    public $isAuthorized;
    // public $menuProducts;

    public function __construct() {
        $this->groupModel = new Group();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
    }

    public function actionIndex($page = 1) { 
        $menuProducts = $this-> groupModel->getOneLevelNameGroups();
        print_r($menuProducts);
        $total = $this->groupModel->getGroupsCount();
        $limit = 6;
        $currentPage = $page;
        $index = 'page=';
        $offset = ($page - 1) * $limit;
        $pagination = new Pagination($total, $currentPage, $limit, $index);
        $groups = $this->groupModel->getAllGroupsPaginated($limit, $offset);
        $title = 'Каталог';
        require_once("views/groups/table.html");

    }












}




?>




