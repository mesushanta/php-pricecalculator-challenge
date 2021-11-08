<?php

class CalculateController
{
    private $calculated_price;
    private $customer;
    private $product;
    private $group;

    /**
     * @param $customer_id
     * @param $group_id
     * @param $product_id
     */
    public function __construct($customer_id,$group_id,$product_id)
    {
        $this->customer = new Customer($customer_id);
        $this->group = new CustomerGroup($group_id);
        $this->product = new Product($product_id);
    }

    public function calculate() {

        $original_price = $this->product->getPrice();
        $customer_discount_type = $this->getDiscountType($this->customer);
        $customer_discount_value =  $this->getDiscountValue($this->customer);
        $customer_group_discount_type = $this->getDiscountType($this->group);
        $customer_group_discount_value = $this->getDiscountValue($this->group);

        if($customer_discount_type == 'fixed' && $customer_group_discount_type == 'fixed') {
            $this->calculated_price = $original_price - $customer_discount_value - $customer_group_discount_value;
        }

        if($customer_discount_type == 'variable' && $customer_group_discount_type == 'variable') {
            if($customer_discount_value > $customer_group_discount_value) {
                $discount = $customer_discount_value;
            }
            else {
                $discount = $customer_group_discount_value;
            }
            $this->calculated_price = $original_price - $this->calculatePercentage($original_price, $discount);
        }

        if($customer_discount_type == 'variable' && $customer_group_discount_type == 'fixed') {
            $discount = $customer_discount_value;
            $this->calculated_price = $original_price - $customer_group_discount_value - $this->calculatePercentage($original_price, $discount);
        }

        if($customer_discount_type == 'fixed' && $customer_group_discount_type == 'variable') {
            $discount = $customer_group_discount_value;
            $this->calculated_price = $original_price - $customer_discount_value - $this->calculatePercentage($original_price, $discount);
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
    private function getDiscountValue($val) {
        if($val->getFixedDiscount() == NULL) {
            $value = $val->getVariableDiscount();
        }
        else {
            $value = $val->getFixedDiscount();
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