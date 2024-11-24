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
                <input type="email" name="email" id="email" class="form-item-input" placeholder="email@address.com" required>
            </div>
            <div class="form-item password-container">
                <label for="password" class="form-item-label">Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" class="form-item-input" placeholder="password" required>
                    <span class="eye-icon" id="togglePassword">
                        <img src="assets/icons/eye-solid.svg" alt="Show Password" class="eye-icon-svg" id="eyeIcon"/>
                    </span>
                </div>
            </div>
            <button type="submit" class="form-item-button">Sign in</button>
        </form>
        <div style="cursor:pointer;margin-bottom: 2rem;" class="fg-pass">
            <a class="fg-pass-link"><u>Esqueceu a senha?</u></a>
        </div>
    </div>
</div>
   <script>

    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.src = 'assets/icons/eye-slash-solid.svg';
        } else {
            passwordField.type = "password";
            eyeIcon.src = 'assets/icons/eye-solid.svg';
        }
    });


    $(document).ready(function () {
    $('#loginForm').submit(function (event) {
        event.preventDefault(); 
        const formData = {
            email: $('#email').val(),
            password: $('#password').val(),
        };

        $.ajax({
            url: 'controllers/access_controller.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                $('#responseMessage').css('display', 'none').removeClass('success error');

                if (response.success) {
                    let redirectUrl = /* '/ecommerce' + */ response.redirectUrl;

                    $('#responseMessage').addClass('success')
                        .html('<p>Login successful! Redirecting...</p>')
                        .css('display', 'block');
                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 2000);
                } else {
                    // Display error message
                    $('#responseMessage').addClass('error')
                        .html(`<p>${response.message}</p>`)
                        .css('display', 'block');
                }
            },
            error: function () {
                $('#responseMessage').css('display', 'none').removeClass('success error').addClass('error')
                    .html('<p>An error occurred. Please try again later.</p>')
                    .css('display', 'block');
            },
        });
    });
});

</script>



</body>
</html>
