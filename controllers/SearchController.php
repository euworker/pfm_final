

    <?php

class SearchController {

    private $searchModel;
    private $groupModel;
    public $isAuthorized;
    // public $menuProducts;

    public function __construct() {
        $this->searchModel = new Search();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();

    }
        // $this->groupModel = new Group();
    

    public function actionIndex(){
        $errors = [];
        $search = [0];
        if (isset($_POST["search"])) {
        $search = htmlentities($_POST["search"]);
        // запписываем куки
        setcookie("search", $search, time() + 2 * 24 * 3600, path:'/');
        // рефрешим страницу чтобы куки появились 
        header("Refresh: 0"); 
        // убиваем выполнение, чтобы записать без ошибок $searchResults
        die; 
    }



        if (empty($errors)) {

            $search = $this->searchModel->checkSearchResult($_COOKIE['search']);
            
            if ($search == '0') {
                $searchResults = $this->searchModel->getSearchResult($_COOKIE['search']);
            } 
            
            if (!empty($searchResults)) {
                setcookie("search", "", time() + 2 * 24 * 3600, path:'/');
                } else {
                    $emptySearch = "К сожалению, ничего не найдено";
                    setcookie("search", "", time() + 2 * 24 * 3600, path:'/');
                }

        }
        
        $title = 'Поиск';
        require_once("views/search/table.html");
    
    
    }

}

?>