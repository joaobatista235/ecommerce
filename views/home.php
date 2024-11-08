<?php include "base\\header.php"; ?>

<div  class="home">
    <div class="grid_produtos">
        <?php foreach ($products as $product): ?>
            <div class="produto">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p>Preço: <?php echo htmlspecialchars($product['price']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
</div>


<?php include "base\\footer.php"; ?>
