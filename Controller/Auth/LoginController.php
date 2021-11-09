<?php

require_once './Helpers/Database.php';

class LoginController
{
    private $email;
    private $password;
    private $table = "customer";
    private $errors = [];
    private $valid;

    /**
     * @param $email
     * @param $password
     */
    public function __construct()
    {
        if(isset($_POST) && !empty($_POST)) {
            $this->doLogin();
        }
    }

    public function doLogin() {
        $this->valid = true;
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(empty($email)) {
            $this->errors['email'] = "Please enter your emails";
            $this->valid = false;
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "This is invalid email";
            $this->valid = false;
        }
        if(empty($password)) {
            $this->errors['password'] = "You must enter password";
            $this->valid = false;
        }

        if($this->valid) {
//          $this->password = password_hash($password, PASSWORD_DEFAULT);
            $user = Database::query("SELECT id,firstname,lastname,email,password FROM " . $this->table . " WHERE email = '".$email."';");
            if(!$user) {
                $this->errors['email'] = "Email does not belongs to any customer";
                $this->valid = false;
            }
            else if (!password_verify($password, $user[0]['password'])) {
                $this->errors['general'] = "Email  and password does not match";
                $this->valid = false;
            }

        }
        if($this->valid) {
            $_SESSION['login'] = 'yes';
            header("Location: ./index.php");
        }
    }

    public function logout() {
        unset($_SESSION['login']);
//        session_unset('login');
        header("Location: ./login.php");
    }
    public function render(array $GET, array $POST)
    {
        require 'View/auth/login.php';
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return mixed
     */
    public function getValid()
    {
        return $this->valid;
    }

}