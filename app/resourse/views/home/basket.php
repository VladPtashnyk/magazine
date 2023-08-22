<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<div>
    <h1>Basket</h1>
</div>

<div class="one-product">
    <?php foreach ($basketProducts as $basketProduct) { ?>
        <div class="basketProduct">
            <figure>
                <figcaption>
                    <p>
                        <b>Main Image :</b>
                        <p>
                            <img src="/app/resourse/uploads/<?= $basketProduct['main_image']?>" alt="<?= $basketProduct['main_image']?>">
                        </p>
                    </p>
                    <p><b>Name Product: </b><?= $basketProduct['name']?></p>
                    <p><b>Quantity : </b><?= $basketProduct['count']?></p>
                    <p><b>Price : </b><?= $basketProduct['price']?></p>
                    <p><b>Total Price : </b><?= $basketProduct['totalPrice']?></p> 
                    <p>
                        <form method="POST">
                            <button type="submit" name="removeBasket" value="<?= $basketProduct['id_product']?>">Remove Basket</button>
                        </form>
                    </p>
                </figcaption>
            </figure>
        </div>
    <?php } ?>
    <form method="POST">
        <button type="submit" name="removeBasket" value="yes">Remove Basket</button>
        <a href="<?= $this->getBaseURL('/home')?>" class="figure-a">Home</a>
        <a href="<?= $this->getBaseURL('/home/order')?>" class="figure-a">Go to order</a>
    </form>
</div>