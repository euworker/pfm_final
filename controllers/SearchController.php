

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
        // рефоешим страницу чтобы куки появились 
        header("Refresh: 0"); 
        // убиваем выполнение, чтобы записсать без ошибок $searchResults
        die; 
    }
 
        // todo проверки !!! регулярки -> если проверка на регулярку не проходит, то записаваем ошибку в
        // errors/ офибку придумаваем сами
        // проверка - значение есть в таблице ! 
        
        if (empty($errors)) {
            
            $searchResults = $this->searchModel->getSearchResult($_COOKIE['search']);
            
        if (!empty($searchResults)) {
            setcookie("search", "", time() + 2 * 24 * 3600, path:'/');
        } else {
            $emptySearch = "К сожалению, ничего не найдено";
        }

            
        }
        
        $title = 'Поиск';
        require_once("views/search/table.html");
    
    
    }



      
        
    // } 


}

?>