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
    private $groupName = "";
    private $email;

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
        $this->email = $row[0]['email'];
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

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function getDiscountType() {
        if($this->fixed_discount == NULL) {
            $type = 'variable';
        }
        else {
            $type = 'fixed';
        }
        return $type;
    }

    public function getDiscountValue() {
        if($this->fixed_discount == NULL) {
            $value = $this->variable_discount;
        }
        else {
            $value = $this->fixed_discount * 100;
        }
        return $value;
    }

}