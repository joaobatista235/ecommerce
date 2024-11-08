document.addEventListener('DOMContentLoaded', function() {
    // Redirect to the login page
    const loginButton = document.getElementById('loginButton');
    if (loginButton) {
        loginButton.addEventListener('click', function() {
            window.location.href = 'views\\login_page.php';
        });
    }

    // Redirect to the sign-up page
    const signupButton = document.getElementById('signupButton');
    if (signupButton) {
        signupButton.addEventListener('click', function() {
            window.location.href = 'views\\chose_profile.php';
        });
    }
});

function redirectToCliente() {
    window.location.href = 'views\\signup_user.php';
}
function redirectToVendedor() {
    window.location.href = 'views\\signup_saler.php';
}
// global.js

// Reusable function to load content dynamically via AJAX
function loadContent(url, containerId) {
    $.ajax({
        url: url,           // The URL to send the GET request to
        method: 'GET',      // HTTP method (GET for fetching content)
        success: function(response) {
            // On success, inject the content into the specified container
            $(containerId).html(response);
        },
        error: function(xhr, status, error) {
            // Handle errors if any
            alert("An error occurred: " + error);
        }
    });
}
function isViewInURL(view) {
    return window.location.href.indexOf(view) > -1;
}
