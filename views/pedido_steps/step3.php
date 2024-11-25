<div class="container-step3">
    <div class="titulo">
        <h1 class="titulo-texto">
            Obrigado por realizar o pedido
        </h1>
    </div>
    <div class="end-session">
        <input type="submit" class="endBtn" id="finalize-btn" value="Finalizar pedido ">
    </div>
</div>

<script>
    document.getElementById('finalize-btn').addEventListener('click', function() {
        // Send the data to the server if needed (like finishing the order or updating the session)
        fetch('../../controllers/finalize_oreder.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'finalizar',  // Action for finalizing the order
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect to the homepage
                    window.location.href = '../views/vendor_dashboard.php';  // Redirect to the homepage

                    // Optionally, you can close the opened pedido section if you have any visibility logic
                    // Assuming you're hiding a section:
                    document.querySelector('.pedidos-body').style.display = 'none'; // Hides pedidos section
                } else {
                    alert('Erro ao finalizar o pedido: ' + data.message);
                }
            }).catch(error => {
            console.error('Erro:', error);
            alert('Erro inesperado ao finalizar o pedido.');
        });
    });
</script>
