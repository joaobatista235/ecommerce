<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><link rel="stylesheet" href="../config/global.css">
<div class="product-list"></div>
    <div class="product-container">
        <h1>Listagem de Produtos</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Quantidade em Estoque</th>
                    <th>Preço</th>
                    <th>Unidade de Medida</th>
                    <th>Promoção</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Produto A</td>
                    <td>150</td>
                    <td class="price">R$ 25,00</td>
                    <td>un</td>
                    <td class="promo">Sim</td>
                    <td><img id="btnExcluir" src="../assets/icons/trash-solid.svg" width="15px"></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Produto B</td>
                    <td>200</td>
                    <td class="price">R$ 45,50</td>
                    <td>kg</td>
                    <td class="no-promo">Não</td>
                    <td><img id="btnExcluir" src="../assets/icons/trash-solid.svg" width="15px"></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Produto C</td>
                    <td>100</td>
                    <td class="price">R$ 12,30</td>
                    <td>un</td>
                    <td class="promo">Sim</td>
                    <td><img id="btnExcluir" src="../assets/icons/trash-solid.svg" width="15px"></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Produto D</td>
                    <td>50</td>
                    <td class="price">R$ 75,00</td>
                    <td>kg</td>
                    <td class="no-promo">Não</td>
                    <td><img id="btnExcluir" src="../assets/icons/trash-solid.svg" width="15px"></td>
                </tr>
            </tbody>
        </table>

        <button class="btn">Cadastrar produto</button>
        <button class="btn">Ver mais produtos</button>

        <script>
        document.getElementById('btnExcluir').addEventListener('click', function() {
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Essa ação não pode ser desfeita!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Excluído!',
                        'O produto foi excluído com sucesso.',
                        'success'
                    );
                    
                } else if (result.isDismissed) {
                    Swal.fire(
                        'Cancelado!',
                        'Ação cancelada.',
                        'info'
                    );
                }
            });
        });
    </script>
    </div>

</div>
