<?php 

$routes = array (

    // platform-it.ru   - '' - каркас гтов
    // каталог platform-it.ru/products/ - ожидается переработка
    // группа товаров platform-it.ru/products/voip/ - не сделан
    // товар platform-it.ru/products/voip/sip-t21-e2 - не сделан
    // корзина platform-it.ru/cart - не сделан
    // заказ оформлен platform-it.ru/cart/success_page - не сделан
    // акции   platform-it.ru/stock - каркас гтов
    // как купить platform-it.ru/how_to_buy - каркас гтов
    // бренды platform-it.ru/manufacturers -каркас готов
    // контакты platform-it.ru/contacts   - каркас гтов


    'ManufacturerController' => array (
        
        'manufacturer/add' => 'add',
        'manufacturer/edit/([0-9+])' => 'edit/$1',
        'manufacturer/delete/([0-9+])' => 'delete/$1',
        'manufacturers/page=([0-9+])' => 'index/$1',
        'manufacturers' => 'index'
    ),

    'UsersController' => array (
        'user/reg' => 'reg',
        'user/auth' => 'auth',
        'logout' => 'logout'
    ),

    'ProductsController' => array (

        // пагинация в группе
        'product/([A-Za-z_]+)/page=([0-9]+)' => 'group/$1/$2',
        // товар
        'product/([A-Za-z_]+)/([A-Za-z0-9_]+)' => 'product/$1/$2',
        // группы
        'product/([A-Za-z_]+)' => 'group/$1',
        // старое
        'product/add' => 'add',
        'product/edit/([0-9+])' => 'edit/$1',
        'product/delete/([0-9+])' => 'delete/$1',
        'products/([0-9]+)' => 'index',
        'products' => 'index'
    ),


    'GroupController' => array (
        'groups/page=([0-9+])' => 'index/$1',
        'groups' => 'index'
        
    ),

    'StocksController' => array (
        'stocks/page=([0-9+])' => 'index/$1',
        'stocks' => 'index'
        
    ),

    // 'CommonController' => array (
    //     'how_to_buy' => 'indexhowtobuy',
    //     'contacts' => 'indexcontacts',
    //     'about' => 'indexabout'
    // ),

    'HowToBuyController' => array (
        'how_to_buy' => 'indexhowtobuy'
    ),

    'ContactsController' => array (
        'contacts' => 'indexcontacts'
    ),

    'AboutController' => array (
        'about' => 'indexabout'
    ),

    
    'MainController' => array (

        '' => 'index'


    )



);

?>