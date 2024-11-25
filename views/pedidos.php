<?php   
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazer pedido</title>
    <link rel="stylesheet" href="../config/global.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="../config/global.js"></script>
</head>
<body class="pedidos-body">
<!-- Navigation Bar -->
<nav class="simple-nav">
    <div class="go-back">
        <a href="../views/vendor_dashboard.php" class="go-back-link">
            <i class='bx bx-left-arrow-alt icon-simple-nav'></i>
        </a>
    </div>
</nav>

<!-- Progress Bar -->
<div class="progress-container">
    <div class="progress-bar">
        <div class="progress" id="progress"></div>
    </div>
    <div class="step-indicators">
        <div class="step active" data-step="1">1</div>
        <div class="step" data-step="2">2</div>
        <div class="step" data-step="3">3</div>
    </div>
</div>

<!-- Main Content -->
<main id="main-content">
    <div class="step-content active" id="step-1">
        <h1>Step 1: Add Products</h1>
        <!-- Step 1 content here -->
    </div>
    <div class="step-content hidden" id="step-2">
        <h1>Step 2: Shipping Details</h1>
        <!-- Step 2 content here -->
    </div>
    <div class="step-content hidden" id="step-3">
        <h1>Step 3: Payment</h1>
        <!-- Step 3 content here -->
    </div>
</main>



<script>
    // Function to load content into the main area dynamically
    function loadContentIntoMain(url, targetId, callback) {
        $(targetId).load(url, function(response, status, xhr) {
            if (status === "error") {
                console.log("Error loading content for: " + url);
            } else {
                if (callback) {
                    callback();  // Call the callback once the content is loaded
                }
            }
        });
    }

    $(document).ready(function() {
        // Initial content load for step 1
        loadContentIntoMain('../views/pedido_steps/step1.php', '#step-1');

        // Handle checkout button click (transition to Step 3)
        $('#checkout-button').click(function() {
            // Remove active class from all steps and hide them
            $('.step').removeClass('active');
            $('.step-content').removeClass('active').addClass('hidden'); // Hide all step content

            // Ensure Step 2 is explicitly hidden
            $('#step-2').addClass('hidden'); // Explicitly hide Step 2 (add this line)

            // Transition to Step 3 (Payment)
            $('#step-3').removeClass('hidden').addClass('active');  // Show step 3
            $('.step[data-step="3"]').addClass('active');  // Highlight Step 3 as active
            console.log('Moved to Step 3');

            // Load step 3 content (no cart logic here)
            loadContentIntoMain('../views/pedido_steps/step3.php', '#step-3', function() {
                // Once the content is loaded, you can force the reflow by hiding and showing the step content
                $('#step-3').removeClass('hidden').addClass('active');
            });

            // Optionally, store any checkout data here if needed (e.g., for confirmation)
            // let checkoutData = {
            //     totalPrice: totalPrice,
            //     cartItems: []
            // };
            // localStorage.setItem('checkoutData', JSON.stringify(checkoutData));
            // Redirect to the confirmation page (if needed)
            // window.location.href = '../views/pedido_steps/step3_confirmation.php'; // Optional: for confirmation page
        });

        // Add item to the cart when clicking the "Add to Cart" button (for Step 1 or other steps)
        $('.add-to-cart').click(function () {
            let productCard = $(this).closest('.product-card');
            let productId = productCard.data('id');
            let quantity = productCard.find('.quantity-input').val();

            addToCart(productId, quantity);
        });

        // Load the cart only if needed (for steps that require cart logic)
        if ($('#step-1').hasClass('active')) {
            updateCart();
        }
    });

</script>


</body>
</html>
