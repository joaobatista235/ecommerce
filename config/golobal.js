document.addEventListener('DOMContentLoaded', function() {
    // Redirect to the login page
    const loginButton = document.getElementById('loginButton');
    if (loginButton) {
        loginButton.addEventListener('click', function() {
            window.location.href = '../views/login_page.php';
        });
    }

    // Redirect to the sign-up page
    const signupButton = document.getElementById('signupButton');
    if (signupButton) {
        signupButton.addEventListener('click', function() {
            window.location.href = '../views/chose_profile.php';
        });
    }
});

function redirectToCliente() {
    window.location.href = 'signup_user.php';
}
function redirectToVendedor() {
    window.location.href = 'signup_saler.php';
}

