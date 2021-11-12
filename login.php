<?php
declare(strict_types=1);

require 'Controller/Auth/LoginController.php';

$controller = new LoginController();
$controller->render($_GET,$_POST);


//if($controller->getValid()){
//    header("Location: ./index.php");
//}
//require 'Model/Customer.php';
