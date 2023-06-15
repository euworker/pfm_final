

    <?php

class SearchController {

    private $searchModel;
    private $groupModel;
    public $isAuthorized;
    // public $searchResults;
    public $menuProducts;

    public function __construct() {
        $this->searchModel = new Search();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        // $this->searchResults = setcookie("search", "", time() + 2 * 24 * 3600, path:'/');
        global $menuProducts;
        $this->menuProducts = $menuProducts;

    }
        // $this->groupModel = new Group();
    

    public function actionIndex(){
        
        $errors = [];
        $emptySearch = "К сожалению, ничего не найдено";
        // $search = [0];
        if (isset($_POST["search"])) {
            // дописать проверку на то что он пост и нужно  толкьо записать  куки
        $search = htmlentities($_POST["search"]);
        $searchCheck = $this->searchModel->checkSearchResult($_COOKIE['search']);
        
        if ($searchCheck == '1') {
            $errors = [$emptySearch];
        }
        
        // запписываем куки
        setcookie("search", $search, time() + 2 * 24 * 3600, path:'/');
        // рефрешим страницу чтобы куки появились 
        header("Refresh: 0"); 
        // убиваем выполнение, чтобы записать без ошибок $searchResults
        die; 
    }
    
        if (empty($errors)) {

            if (isset($_COOKIE['search'])) {
                $searchResults = $this->searchModel->getSearchResult($_COOKIE['search']);
            } 

            if (!empty($searchResults)) {
                    setcookie("search", "", time() + 2 * 24 * 3600, path:'/');
                } else {
                    $emptySearch;
                    setcookie("search", "", time() + 2 * 24 * 3600, path:'/');
                    
                }

        } else {
            $emptySearch;
            setcookie("search", "", time() + 2 * 24 * 3600, path:'/');
        }
        
        $title = 'Поиск';
        require_once("views/search/table.html");
    
    
    }

}

?>