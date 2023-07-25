document.addEventListener('DOMContentLoaded', function () {
    // Get references to the search form and table container
    const searchForm = document.getElementById('search-form');
    const customerFilterdTable = document.getElementById('customer-filterd-table');
    const customerTable = document.getElementById('customer-table');

    // Function to create the HTML table
    function createTable(data) {
        let tableHtml = '<table class="table table-striped table-hover container">' +
            '<thead>' +
            '<tr>' +
            '<th>Order ID</th>' +
            '<th>Customer ID</th>' +
            '<th>Customer Name</th>' +
            '<th>Customer Email</th>' +
            '<th>Number of Orders</th>' +
            '<th>Order Amount</th>' +
            '<th>Created At</th>' +
            '</tr>' +
            '</thead><tbody>';
    
        // Loop through the data and add a new row for each order
        Object.values(data).forEach(function (orderData) {
            const orders = orderData.orders;
            const customer = orderData.customer;

            orders.forEach(function (order) {
    
                tableHtml += '<tr>' +
                    '<td>' + order.order_id + '</td>' +
                    '<td>' + customer.customer_id + '</td>' +
                    '<td>' + customer.customer_name + '</td>' +
                    '<td>' + customer.customer_email + '</td>' +
                    '<td>' + customer.no_orders + '</td>' +
                    '<td>' + order.order_value + '</td>' +
                    '<td>' + order.created_at + '</td>' +
                    '</tr>';
            });
        });
    
        tableHtml += '</tbody></table>';
    
        // Set the HTML content of the customer table
        customerFilterdTable.innerHTML = tableHtml;
    }

    // Handle search form submission
    searchForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission

        // Get the search query from the input field
        const searchQuery = document.getElementById('search-input').value;

        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Configure the AJAX request with the appropriate parameter based on the selected search option
        const searchOption = document.getElementById('search-input').value;
        let ajaxUrl = './blocks/table/table.php?search_query=' + encodeURIComponent(searchQuery);
        if (searchOption !== 'all') {
            ajaxUrl += '&search_option=' + encodeURIComponent(searchOption);
        }
        
        // Set the response type to JSON
        xhr.responseType = 'json';

        // Define what to do when the AJAX request completes
        xhr.onload = function () {
            if (xhr.status === 200) {
                // 'xhr.response' contains the filtered customer data as JSON objects
                const data = xhr.response;

                console.log(data);

                // Call the function to create the HTML table with the filtered data
                //if there is data

                if (data) {
                    createTable(data);

                 // Add display none to the customer-table
                 customerTable.style.display = 'none';
                } else {
                    // Remove display none from the customer-table
                    customerTable.style.display = 'block';
                }
            } else {
                console.error('Request failed:', xhr.status);
            }
        };

        // Define what to do on error
        xhr.onerror = function () {
            console.error('Request error.');
        };



        // Send the AJAX request
        xhr.open('GET', ajaxUrl);
        xhr.send();
    });
});

  
  
  