<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<div>
    <h1>HOME PAGE PRODUCTS</h1>
    <div class="div-view">
        <form method="POST" class="form-view">
            <div>
                <input type="tet" name="product_name" value="<?= $_POST['product_name'] ?? '' ?>" placeholder="Product Name">
            </div>
            <div>
                <select name="id_category">
                    <?php foreach ($allCategories as $category) {?>
                        <option value="<?= $category['id_category'] ?>" <?= (!empty($filters['id_category']) && $filters['id_category'] != $category['id_category']) || (empty($filters['id_category'])) ?: 'selected' ?>>
                            <?= $category['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <select name="id_status">
                        <?php foreach ($allStatus as $status) { ?>
                            <option value="<?= $status['id_status'] ?>" <?= (!empty($filters['id_status']) && $filters['id_status'] != $status['id_status']) || (empty($filters['id_status'])) ?: 'selected' ?>>
                                <?= $status['name'] ?>
                            </option>
                        <?php } ?>
                </select>     
            </div>
            <div>
                <select name="id_sub_category">
                        <?php foreach ($allSubCategories as $subCategory) { ?>
                            <option value="<?= $subCategory['id_sub_category'] ?>" <?= (!empty($filters['idSubCategory']) && $filters['idSubCategory'] != $subCategory['id_sub_category']) || (empty($filters['idSubCategory'])) ?: 'selected' ?>>
                                <?= $subCategory['name'] ?>
                            </option>
                        <?php } ?>
                </select>         
            </div>
            <div>
                <input type="number" name="price[min]" value="<?= $_POST['price']['min'] ?? '' ?>" placeholder="Min price">
                <input type="number" name="price[max]" value="<?= $_POST['price']['max'] ?? '' ?>" placeholder="Max price">
            </div>
            <div class="div-view-button">
                <button type="submit" name="send">Send</button>
            </div>
        </form>
        <form method="POST" class="form-view-reset">
            <button type="submit" name="resetFilters" value="1">Reset Filters</button>
        </form>
    </div>
    <div>
        <?php foreach ($allProducts as $product) { ?>
            <div class="allProducts">
                <div class="products-view">
                    <a href="<?= $this->getBaseURL('product').'?id='. $product['id_product'] ?>" class="figure-a">
                        <figure>
                            <figcaption>
                                <h3>Name Product : <?= $product['name'] ?></h3>
                                <div>
                                    <?= $this->getImage(['name' => $product['main_image']]); ?>
                                </div>
                                <?php foreach ($product['prices'] as $prices) { ?>
                                    <?php foreach ($prices as $status => $price) { ?>
                                        <?php if ($price == $product['price']) { ?>
                                            <p>Price : <?= $price ?></p>    
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </figcaption>
                        </figure>
                    </a>
                    <figure>
                        <form method="POST" class="form-basket">
                            <button type="submit" name="basket" value="<?= $product['id_product'] ?>">Basket</button>
                        </form>
                        <a href="home/basket" class="figure-a">Go to shopping cart</a>
                    </figure>
                </div>
            </div>
        <?php } ?>
    </div>
</div>