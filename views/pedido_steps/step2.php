<?php
require_once "../../models/Produto.php";
include_once "../../models/Pedido.php";
session_start();

if (isset($_SESSION['id_pedido'])) {
    $id_pedido = $_SESSION['id_pedido'];
} else {
    echo "Pedido não encontrado.";
    $id_pedido = 1;
}

// Fetch all products from the database
$produto = new Produto();
$produtos = $produto->getAll();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../config/global.js"></script>'
<script>
    // Function to update the cart UI dynamically
    function updateCart() {
        $.ajax({
            url: '../../controllers/item_pedido_controller.php',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let cartItemsContainer = $('.cart-items');
                    cartItemsContainer.empty(); // Clear current cart
                    response.items.forEach(item => {
                        let cartItem = `
                            <div class="cart-item" data-id="${item.id_item}">
                                <p>Product Name: ${item.nome_produto}</p>
                                <p>Quantity: ${item.qtde}</p>
                                <p>Total Price: $${(item.qtde * item.preco).toFixed(2)}</p>
                                <button class="remove-from-cart">Remove</button>
                            </div>
                        `;
                        cartItemsContainer.append(cartItem);
                    });

                    // Add event listener for remove buttons
                    $('.remove-from-cart').click(function() {
                        let itemId = $(this).closest('.cart-item').data('id');
                        removeItemFromCart(itemId);
                    });
                } else {
                    console.log('Failed to load cart items.');
                }
            },
            error: function() {
                alert('Error loading cart items.');
            }
        });
    }

    // Function to add an item to the cart
    function addToCart(productId, quantity) {
        $.ajax({
            url: '../../controllers/item_pedido_controller.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ productId: productId, quantity: quantity }),
            success: function(response) {
                if (response.success) {
                    alert('Item added to cart!');
                    updateCart(); // Refresh the cart
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error adding item to cart.');
            }
        });
    }

    // Function to remove an item from the cart
    function removeItemFromCart(itemId) {
        $.ajax({
            url: '../../controllers/item_pedido_controller.php',
            method: 'DELETE',
            contentType: 'application/json',
            data: JSON.stringify({ itemId: itemId }),
            success: function(response) {
                if (response.success) {
                    alert('Item removed from cart.');
                    updateCart(); // Refresh the cart
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error removing item from cart.');
            }
        });
    }


    $(document).ready(function() {
        // Set up the click event handler for steps
        $('.step').click(function() {
            var stepNumber = $(this).data('step');
            var stepContentId = '#step-' + stepNumber;
            var stepContentUrl = '../views/pedido_steps/step' + stepNumber + '.php';

            // Remove active class and hide all steps
            $('.step').removeClass('active');
            $('.step-content').removeClass('active').addClass('hidden');

            // Add active class to the clicked step and show the corresponding content
            $(this).addClass('active');
            $(stepContentId).removeClass('hidden').addClass('active');

            // Call the function to load the content into the main area
            loadContentIntoMain(stepContentUrl, stepContentId);
            console.log('Action called for step ' + stepNumber);
        });

        // Initial content load for step 1
        loadContentIntoMain('../views/pedido_steps/step1.php', '#step-1');

        // Handle checkout button click (transition to Step 3)
        $('#checkout-button').click(function() {
            // Remove active class from all steps and hide them
            $('.step').removeClass('active');
            $('.step-content').removeClass('active').addClass('hidden'); // Hide all step content

            // Ensure Step 2 is explicitly hidden (add display: none if not hidden already)
            $('#step-2').addClass('hidden').css('display', 'none'); // Explicitly hide Step 2

            // Transition to Step 3 (Payment)
            $('#step-3').removeClass('hidden').addClass('active');  // Show step 3
            $('.step[data-step="3"]').addClass('active');  // Highlight Step 3 as active
            console.log('Moved to Step 3');

            // Load step 3 content (no cart logic here)
            loadContentIntoMain('../views/pedido_steps/step3.php', '#step-3', function() {
                // Once the content is loaded, you can force the reflow by hiding and showing the step content
                $('#step-3').removeClass('hidden').addClass('active');
            });
        });


        // Add item to the cart when clicking the "Add to Cart" button
        $('.add-to-cart').click(function () {
            let productCard = $(this).closest('.product-card');
            let productId = productCard.data('id');
            let quantity = productCard.find('.quantity-input').val();

            addToCart(productId, quantity);
        });

        // Load the cart when the page is loaded
        updateCart();
    });
</script>


<div class="container-ip">
    <!-- Product Cards Column -->
    <div class="product-column">
        <?php foreach ($produtos as $produtoData): ?>
            <div class="product-card" data-id="<?php echo $produtoData['id']; ?>">
                <h3 class="product-name"><?php echo $produtoData['nome']; ?></h3>
                <p class="product-price">$<?php echo number_format($produtoData['preco'], 2); ?></p>
                <p class="product-amount">Amount in Stock: <?php echo $produtoData['qtde_estoque']; ?></p>
                <input type="number" class="quantity-input" min="1" value="1" max="<?php echo $produtoData['qtde_estoque']; ?>">
                <button class="add-to-cart">+</button>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Cart Column -->
    <div class="cart-column">
        <h3>Your Cart</h3>
        <div class="cart-items">
            <!-- Cart items will be dynamically added here -->
        </div>
        <button id="checkout-button">Checkout</button> <!-- Checkout button -->
    </div>

</div>
