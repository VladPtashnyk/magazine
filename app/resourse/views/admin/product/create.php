<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<h1>Create Product</h1>

<div class="divCreateProduct">
    <form action="" method="POST" enctype="multipart/form-data" class="createProduct">
        <label>
            Напишіть статус товару
            <select name="product_status">
                <?php foreach ($productStatuses as $status) {?>
                    <option value="<?= $status['id_status'] ?>">
                        <?= $status['name'] ?>
                    </option>
                <?php } ?>
            </select>
        </label>
        <div>
            <label>
                Напишіть ім'я продукту
                <input type="text" name="product_name" class="input-width">
            </label>
        </div>
        <textarea name="description" cols="30" rows="10">Опис товару</textarea>
        <label>
            Завантажте фото
            <input type="file" name="fileName" multiple class="fileName">
        </label>
        <label>
            Напишіть кількість товару
            <input type="text" name="quantity" class="input-width">
        </label>
        <div>
            <select name="price_status">
                <?php foreach ($pricesStatuses as $status) {?>
                    <option value="<?= $status['id_status'] ?>">
                        <?= $status['name'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <label>
            Напишіть ціну товару
            <input type="text" name="product_price" class="input-width">
        </label>
        <div>
            <select name="newCategory">
                <?php foreach ($categories as $category) {?>
                    <option value="<?= $category['id_category'] ?>">
                        <?= $category['name'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" name="create">Create</button>
        <p><a href="<?= $this->getBaseURL('/admin/products') ?>">All Products</a></p>
    </form>
</div>