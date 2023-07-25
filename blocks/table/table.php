<?php 
    //include the api-connection.php file
    //include the components/customer.php file


    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    error_reporting(E_ALL);
    ini_set('log_errors', 1);

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require 'D:/xampp/htdocs/eden-project/api-connection.php';


    require 'D:/xampp/htdocs/eden-project/components/customer.php';
    require 'D:/xampp/htdocs/eden-project/components/orders.php';


    // Check if an AJAX search query is received



    // Get customers data and create Customer objects
    $customersData = getCustomersData();
    $customers = array_map(function ($data) {
        return new Customer($data);
    }, $customersData);

    // Get orders data and create Order objects
    $ordersData = getOrdersData();
    $orders = array_map(function ($data) {
        return new Order($data);
    }, $ordersData);

    // Function to combine customers and orders data based on customer_id
    function combineData($customers, $orders) {
        $combinedData = array();
        foreach ($customers as $customer) {
            $customer_id = $customer->customer_id;
            $combinedData[$customer_id]['customer'] = $customer;
        }

        foreach ($orders as $order) {
            $customer_id = $order->customer_id;
            if (isset($combinedData[$customer_id])) {
                $combinedData[$customer_id]['orders'][] = $order;
            }
        }

        return $combinedData;
    }

    // Combine customers and orders data
    $combinedData = combineData($customers, $orders);


    

   // Check if an AJAX search query is received
   if (isset($_GET['search_query'])) {
        $search_query = $_GET['search_query'];

        // Filter combined data based on the search query
        $filteredData = array_filter($combinedData, function ($data) use ($search_query) {
            $customer = $data['customer'];
            $orders = $data['orders'] ?? [];

            // Check if the search query matches any of the fields for the customer or orders
            return
                stripos($customer->customer_id, $search_query) !== false ||
                stripos($customer->customer_name, $search_query) !== false ||
                stripos($customer->customer_email, $search_query) !== false ||
                stripos($customer->created_at, $search_query) !== false ||
                // Loop through the orders and check if the search query matches any order fields
                count(array_filter($orders, function ($order) use ($search_query) {
                    return
                        stripos($order->order_id, $search_query) !== false ||
                        stripos($order->order_value, $search_query) !== false ||
                        stripos($order->created_at, $search_query) !== false;
                })) > 0;
        });

        // Output the filtered data in JSON format
        echo json_encode($filteredData);
        exit;
    } else {
        // Output the combined data in JSON format
        // echo json_encode($combinedData);
        // exit;
    }

    

    $tableHtml = '<table class="table table-striped table-hover container">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Customer Email</th>
            <th>Order Amount</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>';

    // Loop through the combined data and add a new row for each order
    foreach ($combinedData as $data) {
    $customer = $data['customer'];
    $orders = $data['orders'] ?? [];

    foreach ($orders as $order) {
    $tableHtml .= '<tr>
                <td>' . $order->order_id . '</td>
                <td>' . $customer->customer_name . '</td>
                <td>' . $customer->customer_email . '</td>
                <td>' . $order->order_value . '</td>
                <td>' . $order->created_at . '</td>
            </tr>';
    }
    }

    // Close the table
    $tableHtml .= '</tbody></table>';

    // Output the table
    // echo $tableHtml;

?>