<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="config/global.css">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div id="responseMessage"></div>
        <div class="outter">
            <form id="loginForm" class="form">
                <div class="form-item">
                    <label for="email" class="form-item-label">Email</label>
                    <input type="email" name="email" id="email" class="form-item-input" required>
                </div>
                <div class="form-item">
                    <label for="password" class="form-item-label">Password</label>
                    <input type="password" name="password" id="password" class="form-item-input" required>
                </div>
                <button type="submit" class="form-item-button">Sign in</button>
            </form>
            <div class="fg-pass">
                <a class="fg-pass-link"><u>Esqueceu a senha?</u></a>
            </div>
        </div>
    </div>

   <script>
    $(document).ready(function () {
    $('#loginForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        // Collect form data
        const formData = {
            email: $('#email').val(),
            password: $('#password').val(),
        };

        // Send AJAX POST request
        $.ajax({
            url: 'controllers/access_controller.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                // Hide the message initially and reset classes
                $('#responseMessage').css('display', 'none').removeClass('success error');

                // Handle response
                if (response.success) {
                    // Check if the user is an admin or vendor and handle accordingly
                    let redirectUrl = response.redirectUrl; // This now comes from the response

                    // Display success message
                    $('#responseMessage').addClass('success')
                        .html('<p>Login successful! Redirecting...</p>')
                        .css('display', 'block'); // Explicitly set display to block
                    setTimeout(() => {
                        window.location.href = redirectUrl; // Redirect to the appropriate URL
                    }, 2000);
                } else {
                    // Display error message
                    $('#responseMessage').addClass('error')
                        .html(`<p>${response.message}</p>`)
                        .css('display', 'block');
                }
            },
            error: function () {
                // Handle errors
                $('#responseMessage').css('display', 'none').removeClass('success error').addClass('error')
                    .html('<p>An error occurred. Please try again later.</p>')
                    .css('display', 'block'); // Explicitly set display to block
            },
        });
    });
});

</script>



</body>
</html>
