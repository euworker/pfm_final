<?php 

$routes = array (

    'ManufacturerController' => array (
        'manufacturer/add' => 'add',
        'manufacturer/edit/([0-9+])' => 'edit/$1',
        'manufacturer/delete/([0-9+])' => 'delete/$1',
        'manufacturer/([0-9]+)' => 'index',
        'manufacturers/page=([0-9+])' => 'index/$1',
        'manufacturers' => 'index'
    ),

    'UsersController' => array (
        'user/reg' => 'reg',
        'user/auth' => 'auth',
        'logout' => 'logout'
    ),

    'SearchController' => array (
        'search' => 'index'
    ),
    
     
    'ErrorController' => array (
        'errors/404' => '404'   
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

    'CartController' => array (
        'cart/order' => 'order',
        'cart/success' => 'success',
        'cart' => 'index'    
    ),

    'GroupController' => array (
        'groups/page=([0-9+])' => 'index/$1',
        'groups' => 'index'    
    ),

    'StocksController' => array (
        'stocks/page=([0-9+])' => 'index/$1',
        'stocks' => 'index'
    ),

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