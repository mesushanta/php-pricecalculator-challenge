<?php
declare(strict_types=1);

//require_once 'Helpers/Database.php';
//
require 'Model/Customer.php';
require 'Model/CustomerGroup.php';
require 'Model/Product.php';


require 'Controller/HomeController.php';

$controller = new HomeController();
$controller->render($_GET,$_POST);

