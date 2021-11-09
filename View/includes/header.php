<?php

require_once './Controller/Auth/LoginController.php';

session_start();

if(isset($_POST) && !empty($_POST['logout'])) {
    $login = new LoginController();
    $login->logout();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Php Price Calculator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" integrity="sha512-wnea99uKIC3TJF7v4eKk4Y+lMz2Mklv18+r4na2Gn1abDRPPOeef95xTzdwGD9e6zXJBteMIhZ1+68QC5byJZw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<header class="w-full h-20 bg-gray-50 border-b border-gray-200 shadow-xl">
    <nav class="w-full mx-auto max-w-screen-xl text-right">
        <a href="./index.php">
            <button class="px-4 mx-4 h-12 mt-4 bg-gray-300 border border-gray-500 hover:bg-gray-400">
                Home
            </button>
        </a>
        <?php if(isset($_SESSION['login']) && $_SESSION['login'] == 'yes') { ?>
            <form action="" method="post" class="inline-block">
                <button type="submit" name="logout" value="logout" class="px-4 mx-4 h-12 mt-4 bg-gray-300 border border-gray-500 hover:bg-gray-400">
                    Logout
                </button>
            </form>

        <?php } else { ?>
        <a href="./login.php">
            <button class="px-4 mx-4 h-12 mt-4 bg-gray-300 border border-gray-500 hover:bg-gray-400">
                Login
            </button>
        </a>
        <?php } ?>




    </nav>
</header>