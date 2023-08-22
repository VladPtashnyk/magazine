<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<div>
    <h1>Category</h1>
    <p><a href="<?= $this->getBaseURL('category/create') ?>">Create Category</a></p>
    <div>
        <?php foreach ($categories as $category) { ?>
            <div class="allProducts">
                <div class="products">
                    <a href="<?= $this->getBaseURL('category').'?id='. $category['id_category'] ?>" class="figure-a">
                        <figure>
                            <figcaption>
                                <small>Id Category : <?= $category['id_category'] ?></small>
                                <h3>Name Category : <?= $category['name'] ?></h3>
                                <h3>Description : <?= $category['description'] ?></h3>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                <div class="formDeleteUpdate">
                    <div class="form-relative">
                        <a href="<?= $this->getBaseURL('category/delete').'?id='. $category['id_category'] ?>" class="figure-a">Delete</a>
                        <a href="<?= $this->getBaseURL('category/update').'?id='. $product['id_product'] ?>" class="figure-a">Update</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>