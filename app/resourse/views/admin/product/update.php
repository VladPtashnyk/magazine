<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<h1>Update Product</h1>

<div class="divCreateProduct">
    <form action="<?= $this->getBaseURL('/admin/product/update').'?id='. $product['id_product'] ?>" method="POST" enctype="multipart/form-data" class="createProduct">
        <label>
            Змініть статус товару
            <select name="product_status">
                <?php foreach ($productStatuses as $status) {?>
                    <option value="<?= $status['id_status'] ?>" <?= $status['id_status'] !== $product['id_status'] ?: 'selected'?>>
                        <?= $status['name'] ?>
                    </option>
                <?php } ?>
            </select>
        </label>
        <div>
            <label>
                Змініть ім'я продукту
                <input type="text" name="product_name" class="input-width" value="<?= $product['name']?>">
            </label>
        </div>
        <textarea name="description" cols="30" rows="10" placeholder="Опис товару"><?= $product['description'] ?></textarea>
        <?= $this->getImage(['name' => $product['main_image']]);?>
        <label>
            Змініть фото
            <input type="file" name="fileName" multiple class="fileName">
        </label>
        <label>
            Змініть кількість товару
            <input type="text" name="quantity" class="input-width" value="<?= $product['quantity'] ?>">
        </label>
        <div>
            <?php foreach ($productPrices as $price) { ?>
                <div>
                    <div>
                        <label>
                            Змініть ціну товару
                            <input type="text" name="price[<?= $price['id_price'] ?>]" class="input-width" value="<?= $price['price'] ?>">
                        </label>
                    </div>
                    <select name="price_status[<?= $price['id_price'] ?>]">
                        <?php foreach ($pricesStatuses as $status) {?>
                            <option value="<?= $status['id_status'] ?>" <?= $status['id_status'] == $price['id_status'] ? 'selected' : ''?>>
                                <?= $status['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                    <label>
                        <input type="radio" name="active" value="<?= $price['id_price']?>" <?= $price['active'] ? 'checked' : '' ?>>
                        Active
                    </label>
                    <div>
                        <button type="submit" name="deletePrice" value="<?= $price['id_price']?>">Delete Price</button>
                    </div>
                </div>
            <?php } ?>
            <div>
                <div>
                    <label>
                        Додайте ціну товару
                        <input type="text" name="newPrice" class="input-width" value="">
                    </label>
                </div>
                <select name="newPriceStatus">
                    <?php foreach ($pricesStatuses as $status) {?>
                        <option value="<?= $status['id_status'] ?>">
                            <?= $status['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <select name="newCategory">
                    <?php foreach ($categories as $category) {?>
                        <option value="<?= $category['id_category'] ?>" <?= $idCategory !== $category['id_category'] ?: 'selected'?>>
                            <?= $category['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <button type="submit" name="update" value="<?= $product['id_product'] ?>">Update</button>
        <p><a href="<?= $this->getBaseURL('/admin/products') ?>">All Products</a></p>
    </form>
</div>