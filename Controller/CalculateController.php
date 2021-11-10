<?php

class CalculateController
{
    private $calculated_price;
    private $customer;
    private $product;
    private $group;
    private $groupFixedDiscount = 0;
    private $groupVariableDiscount = 0;


    /**
     * @param $customer_id
     * @param $group_id
     * @param $product_id
     */
    public function __construct($customer_id,$product_id)
    {
        $this->customer = new Customer($customer_id);
        $this->group = new CustomerGroup($this->customer->getGroupId());
        $this->product = new Product($product_id);
        $this->calculate();
    }

    private function calculate()
    {
        $discountprice = 0;
        $discountPercentage = 0;

        $original_price = $this->product->getPrice();

        $customer_discount_type = $this->getDiscountType($this->customer);
        $customer_discount_value = $this->getDiscountValue($this->customer);
        $customer_group_discount_type = $this->getDiscountType($this->group);
        $customer_group_discount_value = $this->getDiscountValue($this->group);

        if ($customer_discount_type == 'fixed') {
            $discountprice += $customer_discount_value;
        } else {
            if ($discountPercentage < $customer_discount_value) {
                $discountPercentage = $customer_discount_value;
            }
        }
        if ($customer_group_discount_type == 'fixed') {
            $discountprice += $customer_group_discount_value;
        } else {
            if ($discountPercentage < $customer_group_discount_value) {
                $discountPercentage = $customer_group_discount_value;
            }
        }
        $this->getParentDiscount($this->group);
        $discountprice = $discountprice + $this->groupFixedDiscount;

        if($discountPercentage < $this->groupVariableDiscount) {
            $discountPercentage = $this->groupVariableDiscount;
        }

        $deducted_price = $original_price - $discountprice;
        if($deducted_price <=0) {
            $this->calculated_price = 0;
        }
        else {
            $this->calculated_price = $deducted_price - $this->calculatePercentage($deducted_price, $discountPercentage);
        }

    }

    private function getDiscountType($val) {
        if($val->getFixedDiscount() == NULL) {
            $type = 'variable';
        }
        else {
            $type = 'fixed';
        }
        return $type;
    }

    private function getParentDiscount($var) {
        if(!empty($var->getParentId())) {
            $parent = new CustomerGroup($var->getParentId());
            $parent_group_discount_type = $this->getDiscountType($parent);
            $parent_group_discount_value = $this->getDiscountValue($parent);
            if ($parent_group_discount_type == 'fixed') {
                $this->groupFixedDiscount += $parent_group_discount_value;

            } else {
                if ($this->groupVariableDiscount < $parent_group_discount_value) {
                    $this->groupVariableDiscount = $parent_group_discount_value;
                }
            }
            $this->getParentDiscount($parent);
        }
    }
    private function getDiscountValue($val) {
        if($val->getFixedDiscount() == NULL) {
            $value = $val->getVariableDiscount();
        }
        else {
            $value = $val->getFixedDiscount()*100;
        }
        return $value;
    }

    private function calculatePercentage($value,$per) {
       return  $value *  $per / 100;
    }

    /**
     * @return mixed
     */
    public function getCalculatedPrice()
    {
        return $this->calculated_price;
    }

}