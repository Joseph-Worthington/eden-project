<?php

class Customer {
    public $customer_id;
    public $customer_name;
    public $customer_email;
    public $no_orders;
    public $created_at;
    public $created_at_unix;
    public $customerData;

    // Constructor to initialize the object with data from the API response
    public function __construct($data) {
        $this->customer_id = $data['customer_id'];
        $this->customer_name = $data['customer_name'];
        $this->customer_email = $data['customer_email'];
        $this->no_orders = $data['no_orders'];
        $this->created_at = $data['created_at'];
        $this->created_at_unix = $data['created_at_unix'];
        $this->customerData = $data;
    }

    // Example custom method
    public function greet() {
        return "Hello, my name is $this->customer_name.";
    }

    public function toJson() {
        return json_encode($this->customerData);
    }
}
