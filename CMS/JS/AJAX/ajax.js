
// Function to do input sanitization on the input fields(for sql injection).
function sanitizeInput(input) {
    // Check if invalid characters below are present in the input.
    if (input.includes("<") || input.includes(">") || input.includes("'") ||
        input.includes('"') || input.includes("`") || input.includes(";") ||
        input.includes("\\") || input.includes("/") || input.includes("!") ||
        input.includes("=")) {
        // If no, continue.
        // If yes, alert the user.
        alert("Invalid characters in the input fields. Contact the admin.");
    } else {

        // Remove all the html tags from the input.
        input = input.replace(/(<([^>]+)>)/gi, "");
        // Remove all the single quotes from the input.
        input = input.replace(/'/g, "");
        // Remove all the double quotes from the input.
        input = input.replace(/"/g, "");
        // Remove all the backticks from the input.
        input = input.replace(/`/g, "");
        // Remove all the semicolons from the input.
        input = input.replace(/;/g, "");
        // Remove all the backslashes from the input.
        input = input.replace(/\\/g, "");
        // Remove all the forward slashes from the input.
        input = input.replace(/\//g, "");
        // Remove all the new line characters from the input.
        input = input.replace(/(\r\n|\n|\r)/gm, "");
        // Remove all the tab characters from the input.
        input = input.replace(/\t/g, "");
        // Remove ! and = from the input.
        input = input.replace(/!|=/g, "");

        return input;
    }
}

// Wait until the DOM is ready
$(document).ready(function () {
    // Wait for onClick event on Login button.
    $('#loginButton').click(function () {
        // Sanitize the input fields.
        sanitizeInput($('#email').val());
        sanitizeInput($('#password').val());

        // Send an AJAX request
        $.ajax({
            type: 'POST',
            url: '../../PHP/admin-server.php', // backend file.
            // payload to send to server.
            data: {
                email: $('#email').val(),
                password: $('#password').val(),
            },
            // if success, then do this.
            success: function (response) { // data is the response from server.php, output of the backend file.
                response = JSON.parse(response);
                if (response.status == "success") {
                    console.log(response.message);
                    window.location.href = "./PHP/admin-panel.php";
                } else {
                    alert(response.message);
                }
            }
        });
    });
    $('#addButton').click(function () {
        var formData = new FormData();

        // Sanitize the input fields.
        sanitizeInput($('#pid').val());
        sanitizeInput($('#product_name').val());
        sanitizeInput($('#description').val());
        sanitizeInput($('#price').val());
        sanitizeInput($('#quantity').val());

        // Append pid, product_name, description, price, quantity to formData.
        formData.append('pid', $("#pid").val());
        formData.append('product_name', $("#product_name").val());
        formData.append('description', $("#description").val());
        formData.append('price', $("#price").val());
        formData.append('quantity', $("#quantity").val());

        // Append image to formData.
        var file = $('#image')[0].files[0];
        formData.append('image', file);

        // Send an AJAX request
        $.ajax({
            type: 'POST',
            url: '../../PHP/add-products.php', // backend file.
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            // payload to send to server.
            data: formData,
            // if success, then do this.
            success: function (response) { // data is the response from server.php, output of the backend file.
                response = JSON.parse(response);
                if (response.status == "success") {
                    alert(response.message);
                    location.reload();
                } else if (response == "error") {
                    alert(response.message);
                } else if (response == "image_error") {
                    alert(response.message);
                } else {
                    alert("Some error occured, Try again.");
                }
            }
        });
    });
    $('#updateButton').click(function () {
        // Sanitize the input fields.
        sanitizeInput($('#pid').val());
        sanitizeInput($('#product_name').val());
        sanitizeInput($('#description').val());
        sanitizeInput($('#price').val());
        sanitizeInput($('#quantity').val());

        // for the update button, only the pid is compulsory.
        var formData = new FormData();
        // Append pid, product_name, description, price, quantity to formData.
        if ($('#pid').val() != "") {
            formData.append('pid', $("#pid").val());
            // get all pid from the table column.
            let pid_list = [];
            $('#productsTable').find('tr').each(function () {
                var $tds = $(this).find('td'),
                    pid = $tds.eq(0).text();
                pid_list.push(pid);
            });
            // check if the pid is in the available products.
            if (pid_list.includes($('#pid').val())) {
                formData.append('pid', $("#pid").val());
            } else {
                alert("Please enter a valid product id.");
            }
        } else {
            alert("Please enter the product id.");
        }

        if ($('#product_name').val() != "") {
            console.log("Product Name: " + $("#product_name").val());
            formData.append('name', $("#product_name").val());
        }
        if ($('#description').val() != "") {
            formData.append('description', $("#description").val());
        }
        if ($('#price').val() != "") {
            formData.append('price', $("#price").val());
        }
        if ($('#quantity').val() != "") {
            formData.append('quantity', $("#quantity").val());
        }

        // Append image to formData.
        var file = $('#image')[0].files[0];
        formData.append('image', file);

        // Send an AJAX request
        $.ajax({
            type: 'POST',
            url: '../../PHP/update-products.php', // backend file.
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            // payload to send to server.
            data: formData,
            // if success, then do this.
            success: function (response) { // response is the response from server.php, output of the backend file.
                response = JSON.parse(response);
                if (response.status == "success") {
                    alert(response.message);
                    location.reload();
                } else if (response == "error") {
                    alert(response.message);
                } else if (response == "image_error") {
                    alert(response.message);
                } else {
                    alert("Some error occured, Try again.");
                }
            }
        });
    });
    $('#deleteButton').click(function () {

        // Sanitize the input fields.
        sanitizeInput($('#oid').val());

        // Check if the oid is present in the table with id 'orders_table'.
        let oid_list = [];
        $('#orders_table').find('tr').each(function () {
            var $tds = $(this).find('td'),
                oid = $tds.eq(0).text();
            oid_list.push(oid);
        });

        // Send an AJAX request if the oid is present in the table.
        if (oid_list.includes($('#oid').val())) {
            $.ajax({
                type: 'POST',
                url: '../../PHP/delete-order.php', // backend file.
                // payload to send to server.
                data: {
                    orderId: $('#oid').val(),
                },
                // if success, then do this.
                success: function (response) { // response is the response from server.php, output of the backend file.
                    response = JSON.parse(response);
                    if (response.status == "success") {
                        alert(response.message);
                        location.reload();
                    } else if (response == "error") {
                        alert(response.message);
                    } else {
                        alert("Some error occured, Try again.");
                    };
                }
            });
        } else {
            alert("Please enter a valid order id.");
        };
    });
});