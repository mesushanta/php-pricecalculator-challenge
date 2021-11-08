<?php

require_once './Helpers/Database.php';

class Product
{
    private $table = "product";
    private $name;
    private $price;

    /**
     * @param $id
     */
    public function __construct($id)
    {
        $row = Database::query('SELECT * FROM ' . $this->table . ' WHERE id = ' . $id);
        $this->name = $row[0]['name'];
        $this->price = $row[0]['price'];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }



}