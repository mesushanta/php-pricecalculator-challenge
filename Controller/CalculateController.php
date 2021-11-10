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
        if (!empty($this->group->getParentId())) {
            $parent = new CustomerGroup($this->group->getParentId());
            $parent_group_discount_type = $this->getDiscountType($parent);
            $parent_group_discount_value = $this->getDiscountValue($parent);

            if ($parent_group_discount_type == 'fixed') {
                $discountprice += $parent_group_discount_value;

            } else {
                if ($discountPercentage < $parent_group_discount_value) {
                    $discountPercentage = $parent_group_discount_value;
                }
            }

            if($parent->getParentId() != NULL) {
                $parent2 = new CustomerGroup($parent->getParentId());
                $parent2_group_discount_type = $this->getDiscountType($parent2);
                $parent2_group_discount_value = $this->getDiscountValue($parent2);

                if($parent2_group_discount_type == 'fixed') {
                    $discountprice += $parent2_group_discount_value;

                }
                else {
                    if($discountPercentage < $parent2_group_discount_value) {
                        $discountPercentage = $parent2_group_discount_value;
                    }
                }

            }

        }

            $deducted_price = $original_price - $discountprice;
            $this->calculated_price = $deducted_price - $this->calculatePercentage($deducted_price, $discountPercentage);

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