<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<div>
    <h1>Sub Category</h1>
    <p><a href="<?= $this->getBaseURL('subCategory/create') ?>">Create Category</a></p>
    <div>
        <?php foreach ($subCategories as $subCategory) { ?>
            <div class="allProducts">
                <div class="products">
                    <a href="<?= $this->getBaseURL('subCategory').'?id='. $subCategory['id_sub_category'] ?>" class="figure-a">
                        <figure>
                            <figcaption>
                                <small>Id Sub Category : <?= $subCategory['id_category'] ?></small>
                                <h3>Name Sub Category : <?= $subCategory['name'] ?></h3>
                                <h3>Description : <?= $subCategory['description'] ?></h3>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                <div class="formDeleteUpdate">
                    <div class="form-relative">
                        <a href="<?= $this->getBaseURL('subCategory/delete').'?id='. $subCategory['id_sub_category'] ?>" class="figure-a">Delete</a>
                        <a href="<?= $this->getBaseURL('subCategory/update').'?id='. $subCategory['id_sub_category'] ?>" class="figure-a">Update</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>