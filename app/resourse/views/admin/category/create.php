<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<h1>Create Category</h1>

<div class="divCreateProduct">
    <form action="" method="POST" class="createProduct">
        <label>
        <div>
            <label>
                Напишіть ім'я категорії
                <input type="text" name="category_name" class="input-width">
            </label>
        </div>
        <textarea name="description" cols="30" rows="10">Опис категорії</textarea>
        <button type="submit" name="create">Create</button>
        <p><a href="<?= $this->getBaseURL('/admin/categories') ?>">All Categories</a></p>
    </form>
</div>