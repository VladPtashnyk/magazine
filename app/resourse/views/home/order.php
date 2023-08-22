<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<body>
    <div class="wrapper">
    <h1>Створити Замовлення</h1>
        <div>
            <?php foreach ($basketProducts as $basketProduct) { ?>
                <div>
                    <figure class="oneBasketProduct">
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
                        </figcaption>
                    </figure>
                </div>
            <?php } ?>
        </div>
        <form action="" method="POST" class="form">
            <input type="tel" name="phone" placeholder="123-4567-8901">
            <input type="email" name="email" placeholder="vlad@gmail.com">
            <input type="text" name="name" placeholder="Vlad">
            <input type="text" name="second_name" placeholder="Ptashnyk">
            <input type="submit" name="order" value="Замовити">
        </form>
    </div>
</body>