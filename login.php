<?php
declare(strict_types=1);
if(isset($_SESSION['login']) && !empty($_SESSION['login'])) {
    header("Location: ./index.php");
}

require 'Controller/Auth/LoginController.php';

$controller = new LoginController();
$controller->render($_GET,$_POST);


//if($controller->getValid()){
//    header("Location: ./index.php");
//}
//require 'Model/Customer.php';
