<?php
declare(strict_types=1);

require_once 'Helpers/Database.php';

//include all your model files here
require 'Model/User.php';
//include all your controllers here
require 'Controller/HomepageController.php';
require 'Controller/InfoController.php';
require 'Controller/IndexController.php';

require 'Model/Customer.php';
require 'Model/CustomerGroup.php';
require 'Model/Product.php';

//you could write a simple IF here based on some $_GET or $_POST vars, to choose your controller
//this file should never be more than 20 lines of code!

$controller = new HomepageController();

$customer = new Customer(1);
var_dump($customer->getFirstname());

if(isset($_GET['page']) && $_GET['page'] === 'info') {
    $controller = new InfoController();
}

if(isset($_GET['page']) && $_GET['page'] === 'newpage') {
    $controller = new IndexController();
}


$controller->render($_GET, $_POST);