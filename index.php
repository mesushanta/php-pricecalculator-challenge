<?php
declare(strict_types=1);

require_once 'Helpers/Database.php';

require 'Model/Customer.php';
require 'Model/CustomerGroup.php';
require 'Model/Product.php';


require 'Controller/HomeController.php';
//you could write a simple IF here based on some $_GET or $_POST vars, to choose your controller
//this file should never be more than 20 lines of code!

$controller = new HomeController();

//if(isset($_GET['page']) && $_GET['page'] === 'info') {
//    $controller = new InfoController();
//}
//
//if(isset($_GET['page']) && $_GET['page'] === 'newpage') {
//    $controller = new IndexController();
//}
//
//
$controller->render($_GET,$_POST);
