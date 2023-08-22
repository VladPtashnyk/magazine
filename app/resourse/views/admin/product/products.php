<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<div>
    <h1>PRODUCTS</h1>
    <p><a href="<?= $this->getBaseURL('product/create') ?>">Create Product</a></p>
    <div>
        <form method="POST">
        <div>
            <input type="tet" name="product_name" value="<?= $_POST['product_name'] ?? '' ?>" placeholder="Product Name">
        </div>
            <select name="id_category">
                <?php foreach ($allCategories as $category) {?>
                    <option value="<?= $category['id_category'] ?>" <?= (!empty($filters['id_category']) && $filters['id_category'] != $category['id_category']) || (empty($filters['id_category'])) ?: 'selected' ?>>
                        <?= $category['name'] ?>
                    </option>
                <?php } ?>
            </select>
            <select name="id_status">
                    <?php foreach ($allStatus as $status) { ?>
                        <option value="<?= $status['id_status'] ?>" <?= (!empty($filters['id_status']) && $filters['id_status'] != $status['id_status']) || (empty($filters['id_status'])) ?: 'selected' ?>>
                            <?= $status['name'] ?>
                        </option>
                    <?php } ?>
            </select>     
            <select name="id_sub_category">
                    <?php foreach ($allSubCategories as $subCategory) { ?>
                        <option value="<?= $subCategory['id_sub_category'] ?>" <?= (!empty($filters['idSubCategory']) && $filters['idSubCategory'] != $subCategory['id_sub_category']) || (empty($filters['idSubCategory'])) ?: 'selected' ?>>
                            <?= $subCategory['name'] ?>
                        </option>
                    <?php } ?>
            </select>         
            <div>
                <input type="number" name="price[min]" value="<?= $_POST['price']['min'] ?? '' ?>" placeholder="Min price">
                <input type="number" name="price[max]" value="<?= $_POST['price']['max'] ?? '' ?>" placeholder="Max price">
            </div>
            <button type="submit" name="send">Send</button>
        </form>
        <form method="POST">
            <button type="submit" name="resetFilters" value="1">Reset Filters</button>
        </form>
    </div>
    <div>
        <?php foreach ($allProducts as $product) { ?>
            <div class="allProducts">
                <div class="products">
                    <a href="<?= $this->getBaseURL('product').'?id='. $product['id_product'] ?>" class="figure-a">
                        <figure>
                            <figcaption>
                                <small>Id Product : <?= $product['id_product'] ?></small>
                                <h3>Name Product : <?= $product['name'] ?></h3>
                                <div>
                                    <?= $this->getImage(['name' => $product['main_image']]); ?>
                                </div>
                                <?php foreach ($product['prices'] as $prices) { ?>
                                    <?php foreach ($prices as $status => $price) { ?>
                                        <?php if ($price == $product['price']) { ?>
                                            <p>Status : <?= $status ?> - Price : <?= $product['price'] ?></p>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <div>
                                    <small>Id Category : <?= $product['id_category'] ?></small>
                                    <small>Category : <?= $product['category_name'] ?></small>
                                </div>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                <div class="formDeleteUpdate">
                    <div class="form-relative">
                        <a href="<?= $this->getBaseURL('product/delete').'?id='. $product['id_product'] ?>" class="figure-a">Delete</a>
                        <a href="<?= $this->getBaseURL('product/update').'?id='. $product['id_product'] ?>" class="figure-a">Update</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>