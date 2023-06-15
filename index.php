<?php

require_once("configs/constants.php");
// include_once("configs/db.php");
require_once("components/autoload.php");




// require_once("components/router.php");

//include_once("views/common/header.html");

$menu = new Menu();
$menuProducts = $menu -> getOneLevelNameGroups();
// print_r($menuProducts);
// die;
// $menuProducts = $menu -> links();
$router = new Router();
//  дописать  модель и сонтроллер ддля вывода данных в хедере
 
// // переменная существет только до хапуска роутера

// print_r($menuProducts);


$router->run();



//include_once("views/common/footer.html");

?>