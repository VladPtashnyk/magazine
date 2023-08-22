<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<div>
    <h1>OneProduct</h1>
</div>

<div class="one-product">
    <figure>
        <figcaption>
            <p><b> Product : </b><?= $product['id_product']?></p>
            <p><b>Name : </b><?= $product['name']?></p>
            <p><b>Description : </b><?=$product['description'] ?></p>
            <p><b>Quantity : </b><?= $product['quantity']?></p>
            <p><b>Main Image :
                <p><img src="/app/resourse/uploads/<?= $product['main_image']?>" alt="<?= $product['main_image']?>"></p>
            </p>
            <?php foreach ($prices as $price) { ?>
                <p><b>Id Price : </b><?= $price['id_price']?></p>
                <p><b>Price Id Product : </b><?= $price['id_product']?></p>
                <p><b>Price : </b><?= $price['price']?></p>
            <?php } ?>
            <?php foreach ($pricesStatus as $prieStatus) { ?>
                <p><b>Price Status Name : </b><?= $prieStatus['name']?></p> 
            <?php } ?>
        </figcaption>
    </figure>
</div>