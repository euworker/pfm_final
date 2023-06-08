<?php

require_once("configs/constants.php");
// include_once("configs/db.php");
require_once("components/autoload.php");




// require_once("components/router.php");

//include_once("views/common/header.html");



$router = new Router();
//  дописать  модель и сонтроллер ддля вывода данных в хедере
// $menu = new Menu();
// // переменная существет только до хапуска роутера
// $menuProducts = $menu -> getOneLevelNameGroups();
// print_r($menuProducts);


$router->run();



//include_once("views/common/footer.html");

?>