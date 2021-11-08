<?php

require_once './Helpers/Database.php';

class CustomerGroup
{
    private $table = "customer_group";
    private $id;
    private $name;
    private $parent_id;
    private $fixed_discount;
    private $variable_discount;

    /**
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
        $row = Database::query('SELECT * FROM ' . $this->table . ' WHERE id = ' . $id);
        $this->name = $row[0]['name'];
        $this->parent_id = $row[0]['parent_id'];
        $this->fixed_discount = $row[0]['fixed_discount'];
        $this->variable_discount = $row[0]['variable_discount'];
    }

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @return mixed
     */
    public function getFixedDiscount()
    {
        return $this->fixed_discount;
    }

    /**
     * @return mixed
     */
    public function getVariableDiscount()
    {
        return $this->variable_discount;
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
    public function getId()
    {
        return $this->id;
    }

}