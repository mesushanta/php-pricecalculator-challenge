<?php
declare(strict_types = 1);

require_once './Helpers/Database.php';
require_once './Controller/CalculateController.php';

class HomeController
{
    private $products = [];
    private $customers = [];
    private $group;
    private $calculate;
    private $result = false;

    /**
     * @param $products
     * @param $customers
     * @param $customers_groups
     */

    public function __construct()
    {
        if(isset($_GET['category']) && $_GET['category'] > 1 && $_GET['category'] <= 7) {
            $this->products = Database::query('SELECT id,name FROM product WHERE category_id = ' . $_GET['category'] . ' ORDER BY name');
        }
        else {
            $this->products = Database::query('SELECT id,name FROM product ORDER BY name');
        }
        $this->customers = Database::query('SELECT id,firstname,lastname FROM customer ORDER BY firstName');
        $this->categories = Database::query('SELECT * FROM category ORDER BY name');
        if(isset($_POST) && !empty($_POST['calculate'])) {

            $this->calculate = new CalculateController($_POST['customer_id'],$_POST['product_id'],$_POST['quantity'] );

            $this->result = true;
        }

    }


    public function render(array $GET, array $POST)
    {
        //this is just example code, you can remove the line below

        //you should not echo anything inside your controller - only assign vars here
        // then the view will actually display them.

        //load the view

        require 'View/home.php';
    }

    /**
     * @return array|false
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return array|false
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * @return array|false
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @return mixed
     */
    public function getCalculate()
    {
        return $this->calculate;
    }

    /**
     * @return bool
     */
    public function isResult(): bool
    {
        return $this->result;
    }

    /**
     * @return array|CustomerGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }






}