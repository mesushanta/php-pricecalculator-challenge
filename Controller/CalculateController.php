<?php

class CalculateController
{
    private $calculated_price;
    private $customer;
    private $product;
    private $group;
    private $quantity;
    private $unit_price;
    private $totalFixedDiscount = 0;
    private $totalVariableDiscount = 0;
    private $parentLevel = 0;
    private $parentLevelArray = [];


    /**
     * @param $customer_id
     * @param $group_id
     * @param $product_id
     */
    public function __construct($customer_id,$product_id,$quantity = 1)
    {
        $this->customer = new Customer($customer_id);
        $this->group = new CustomerGroup($this->customer->getGroupId());
        $this->product = new Product($product_id);
        $this->quantity = $quantity;
        $this->calculate();
    }

    private function calculate()
    {
        $this->unit_price = $this->product->getPrice();
        if($this->quantity >= 50 && $this->quantity <=99 ) {
            // 1% discount
            $this->unit_price = $this->unit_price * 0.99;
        }
        if($this->quantity > 99) {
            // 2% discount
            $this->unit_price = $this->unit_price * 0.98;
        }


        $customer_discount_type = $this->customer->getDiscountType();
        $customer_discount_value = $this->customer->getDiscountValue();
        $customer_group_discount_type = $this->group->getDiscountType();
        $customer_group_discount_value = $this->group->getDiscountValue();

        if ($customer_discount_type == 'fixed') {
            $this->totalFixedDiscount += $customer_discount_value;
        } else {
            if ($this->totalVariableDiscount < $customer_discount_value) {
                $this->totalVariableDiscount = $customer_discount_value;
            }
        }
        if ($customer_group_discount_type == 'fixed') {
            $this->totalFixedDiscount += $customer_group_discount_value;
        } else {
            if ($this->totalVariableDiscount < $customer_group_discount_value) {
                $this->totalVariableDiscount = $customer_group_discount_value;
            }
        }
        $this->getParentDiscount($this->group);

        $this->calculated_price = $this->unit_price - $this->totalFixedDiscount;
        if($this->calculated_price <=0) {
            $this->calculated_price = 0;
        }
        else {
            $this->calculated_price = $this->calculated_price - $this->calculatePercentage($this->calculated_price, $this->totalVariableDiscount);
        }

    }

    private function getParentDiscount($var) {
        if(!empty($var->getParentId())) {
            $parent = new CustomerGroup($var->getParentId());
            $parent_group_discount_type = $parent->getDiscountType();
            $parent_group_discount_value = $parent->getDiscountValue();
            if ($parent_group_discount_type == 'fixed') {
                $this->totalFixedDiscount += $parent_group_discount_value;

            } else {
                if ($this->totalVariableDiscount < $parent_group_discount_value) {
                    $this->totalVariableDiscount = $parent_group_discount_value;
                }
            }
            array_push($this->parentLevelArray,$var->getParentId());
            $this->parentLevel ++;
            $this->getParentDiscount($parent);
        }
    }

    private function calculatePercentage($value,$per) {
       return  $value *  $per / 100;
    }

    /**
     * @return mixed
     */
    public function getCalculatedPrice()
    {
        return $this->calculated_price * $this->quantity;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return CustomerGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return int
     */
    public function getParentLevel()
    {
        return $this->parentLevel;
    }

    /**
     * @return array
     */
    public function getParentLevelArray()
    {
        return $this->parentLevelArray;
    }

    /**
     * @return mixed
     */
    public function getUnitPrice()
    {
        return $this->unit_price;
    }


}