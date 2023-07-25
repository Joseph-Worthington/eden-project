<?php

// components/orders.php
class Order {
    public $order_id;
    public $order_value;
    public $customer_id;
    public $customer_name;
    public $customer_email;
    public $created_at;
    public $created_at_unix;

    public function __construct($data) {
        $this->order_id = $data['order_reference'];
        $this->order_value = $data['order_value'];
        $this->customer_id = $data['customer_id'];
        $this->customer_name = $data['customer_name'];
        $this->customer_email = $data['customer_email'];
        $this->created_at = $data['created_at'];
        $this->created_at_unix = $data['created_at_unix'];
    }
}
