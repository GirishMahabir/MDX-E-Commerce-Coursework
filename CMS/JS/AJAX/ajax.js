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
                console.log(data);
            }
        });
    });
});
