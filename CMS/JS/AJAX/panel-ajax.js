// Wait until the DOM is ready
$(document).ready(function () {
    $('#addButton').click(function () {

        var fd = new FormData();
        var files = $('#image')[0].files[0];
        fd.append('file', files);

        // Send an AJAX request
        $.ajax({
            type: 'POST',
            url: '../../PHP/add-products.php', // backend file.
            // payload to send to server.
            data: {
                pid: $('#pid').val(),
                product_name: $('#product_name').val(),
                description: $('#description').val(),
                price: $('#price').val(),
                quantity: $('#quantity').val(),
                image: fd
            },
            // if success, then do this.
            success: function (data) { // data is the response from server.php, output of the backend file.
                console.log('success');
            }
        });
    });
});