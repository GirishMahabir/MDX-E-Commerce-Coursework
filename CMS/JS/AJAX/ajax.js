// Just Output Username and Password on Console.

// Wait until the DOM is ready
$(document).ready(function () {
    // Wait for onClick event on Login button.
    $('#loginButton').click(function () {
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
            success: function (data) { // data is the response from server.php, output of the backend file.
                // Redirect to admin panel page.
                window.location.href = "../../PHP/admin-panel.php";
            }
        });
    });
    $('#addButton').click(function () {
        var formData = new FormData();
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
            success: function (data) { // data is the response from server.php, output of the backend file.
                // output the response on console.
                console.log(data);
            }
        });
    });
});
