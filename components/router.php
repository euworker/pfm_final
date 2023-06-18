<?php 
//  require_once("controllers/ManufacturerController.php");

class Router {
    private $routes;

    public function __construct(){
        // подключение конфигурационных файлов
        require_once("configs/routes.php");
        $this->routes = $routes;

    }

    public function run() {
        $requestedUrl = $_SERVER['REQUEST_URI'];
        foreach ($this->routes as $controller=>$paths) {
            foreach ($paths as $url=>$actionWithParameters ) {
                // новый
                if (preg_match("~$url~", $requestedUrl)) {
                // if (SITE_ROOT . $url === $requestedUrl) {
                    $actionWithParameters = preg_replace("~$url~", $actionWithParameters, $requestedUrl);
                    $count = 1;
                    // pav2022/pfm_final/edit/23 => edit/23 преобразуем url 
                    $actionWithParameters = str_replace(SITE_ROOT, '', $actionWithParameters, $count);
                    // [edit,1]
                    $actionWithParametersArray =  explode('/', $actionWithParameters);
                    $action = array_shift($actionWithParametersArray); 
                    $requestedController = new $controller();
                    $requestedAction = "action" . ucfirst($action);
                    // $requestedController->$requestedAction();
                    try{
                        call_user_func_array(array($requestedController, $requestedAction), $actionWithParametersArray);
                        } catch (Exception $e) {
                        echo "Ошибка";
                        }
                    
                    break 2;

                }
            } 
        }


    }




}




?>