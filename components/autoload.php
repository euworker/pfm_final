<?php
// функция автоподключения, если не подключен инклудом класс

spl_autoload_register(function ($class) {

$dirs = ['components', 'controllers', 'models'];

foreach ($dirs as $dir) {
    $fileName = "$dir/" . mb_strtolower($class) . ".php";
    if (file_exists($fileName)) {
         if ($dir =='models'){ var_dump($fileName);}
        require_once($fileName);
    }
 }

}

) 


?>