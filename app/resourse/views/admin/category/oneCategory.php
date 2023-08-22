<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<div>
    <h1>OneCategory</h1>
</div>

<div class="one-product">
    <figure>
        <figcaption>
            <p><b> Id Category : </b><?= $category['id_category']?></p>
            <p><b>Name Category : </b><?= $category['name']?></p>
            <p><b>Description : </b><?=$category['description'] ?></p>
        </figcaption>
    </figure>
</div>