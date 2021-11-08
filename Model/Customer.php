<?php

require_once './Helpers/Database.php';

class Customer
{
    private $table = "customer";
    private $firstname;
    private $lastname;
    private $group_id;
    private $fixed_discount;
    private $variable_discount;

    /**
     * @param $id
     */
    public function __construct($id)
    {
        $row = Database::query('SELECT * FROM ' . $this->table . ' WHERE id = ' . $id);
        $this->firstname = $row[0]['firstname'];
        $this->lastname = $row[0]['lastname'];
        $this->group_id = $row[0]['group_id'];
        $this->fixed_discount = $row[0]['fixed_discount'];
        $this->variable_discount = $row[0]['variable_discount'];
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->group_id;
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



}