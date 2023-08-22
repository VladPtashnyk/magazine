<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<h1>Update Sub Category</h1>

<div class="divCreateProduct">
    <form action="" method="POST" class="createProduct">
        <div>
            <select name="newCategory">
                <?php foreach ($categories as $category) {?>
                    <option value="<?= $category['id_category'] ?>" <?= $subCategory['id_category'] !== $category['id_category'] ?: 'selected' ?>>
                        <?= $category['name'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label>
                Напишіть ім'я саб категорії
                <input type="text" name="sub_category_name" class="input-width" value="<?= $subCategory['name'] ?>">
            </label>
        </div>
        <textarea name="description" cols="30" rows="10"><?= $subCategory['description'] ?></textarea>
        <button type="submit" name="update">Update</button>
        <p><a href="<?= $this->getBaseURL('/admin/subCategories') ?>">All Sub Categories</a></p>
    </form>
</div>