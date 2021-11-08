<?php
declare(strict_types = 1);

require_once './Helpers/Database.php';

class HomepageController
{
    private $products = [];
    private $customers = [];
    private $groups = [];

    /**
     * @param $products
     * @param $customers
     * @param $customers_groups
     */

    public function __construct($products, $customers, $groups)
    {
        $this->products = Database::query('SELECT * FROM product');
        $this->customers = Database::query('SELECT * FROM customer');
        $this->groups = Database::query('SELECT * FROM cuastomer_group');
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




}