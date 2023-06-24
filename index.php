<?php

require_once("configs/constants.php");
// include_once("configs/db.php");
require_once("components/autoload.php");




// require_once("components/router.php");

//include_once("views/common/header.html");

$menu = new Menu();
$menuProducts = $menu -> getOneLevelNameGroups();

$router = new Router();


$router->run();



//include_once("views/common/footer.html");

?>