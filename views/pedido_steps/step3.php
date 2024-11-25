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
    document.getElementById('finalize-btn').addEventListener('click', function () {
        fetch('../controllers/finalize_oreder.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'finalizar',
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '../views/vendor_dashboard.php';

                    document.querySelector('.pedidos-body').style.display = 'none';
                } else {
                    alert('Erro ao finalizar o pedido: ' + data.message);
                }
            }).catch(error => {
            console.error('Erro:', error);
            alert('Erro inesperado ao finalizar o pedido.');
        });
    });
</script>
