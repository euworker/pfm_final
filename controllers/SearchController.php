

    <?php

class SearchController  {

    private $searchModel;
    private $groupModel;
    public $isAuthorized;
    // public $searchResults;
    public $menuProducts;

    public function __construct() {
        $this->searchModel = new Search();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        global $menuProducts;
        $this->menuProducts = $menuProducts;

    }
    
    public function actionIndex(){
        
        $errors = [];
        
        // $search = [0];
        if (isset($_POST["search"])) {

            $search = htmlentities($_POST["search"]);

            if (isset($search) ){
                $searchCheck = $this->searchModel->checkSearchResult($search);
                if ($searchCheck == '0') { 
                    setcookie("search", $search, time() + 2 * 24 * 3600, path:'/');
                } else {
                    setcookie("search", "", time() + 2 * 24 * 3600, path:'/');
                }
            } 
            header("Refresh: 0"); 
            // убиваем выполнение, чтобы записать без ошибок $searchResults
            die; 
        }
    
        if (!empty($_COOKIE['search'])) {
            $searchResults = $this->searchModel->getSearchResult($_COOKIE['search']);

            if (empty($searchResults)) {
                $emptySearch = "К сожалению, ничего не найдено";
                setcookie("search", "", time() + 2 * 24 * 3600, path:'/');
            }
        } else {
            $emptySearch = "К сожалению, ничего не найдено";
            setcookie("search", "", time() + 2 * 24 * 3600, path:'/');
        }
        
        $title = 'Поиск';
        require_once("views/search/table.html");
    
    
    }

}

?>