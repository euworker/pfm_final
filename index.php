<?php

require_once("configs/constants.php");

require_once("components/autoload.php");

$menu = new Menu();
$menuProducts = $menu -> getOneLevelNameGroups();
$router = new Router();

$router->run();

?>