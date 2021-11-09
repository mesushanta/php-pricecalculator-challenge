<?php require './View/includes/header.php'?>
<?php if(isset($_SESSION['login']) && $_SESSION['login'] == 'yes') {
    header("Location: ./index.php");
}?>

    <section class="w-full mx-auto px-4 my-20 max-w-screen-md">
        LOGIN
        <?php
        $controller = new LoginController();
        if(isset($_POST) && !empty($_POST) && ($_POST['login'] == 'login') ) {
            $errors = $controller->getErrors();
        }
        ?>
        <form class="" method="post">
            <div class="my-4">
                <input name="email" type="text" class="w-full px-4 h-12 border border-gray-400">
                <?php
                if(isset($errors['email'])) {
                ?>
                <span class="text-red-700 text-sm font-light"><?php echo $errors['email'] ?></span>
                <?php } ?>
            </div>

            <div class="my-4">
                <input name="password" type="password" class="w-full px-4 h-12 border border-gray-400">
                <?php
                    if(isset($errors['password'])) {
                ?>
                    <span class="text-red-700 text-sm font-light"><?php echo $errors['password'] ?></span>
                <?php } ?>
            </div>
            <div class="">
                <button class="w-full h-12 text-center bg-blue-500 hover:bg-blue-600 border border-blue-700 text-white" type="submit" name="login" value="login">Login</button>
            </div>
        </form>
    </section>
<?php require './View/includes/footer.php'?>