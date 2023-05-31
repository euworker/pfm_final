<?php

//  require_once("models/manufacturer.php");

class GroupController {

    private $groupModel;
    public $isAuthorized;

    public function __construct() {
        $this->groupModel = new Group();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
    }

    public function actionIndex($page = 1) { 
        // $manufacturers = $this->mainModel->getTotal();
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




