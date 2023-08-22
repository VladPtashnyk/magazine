<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<h1>dashboard</h1>
<div>
    <a href="<?= $this->getBaseURL('status') ?>">Status</a>
    <a href="<?= $this->getBaseURL('products') ?>">Product</a>
    <a href="<?= $this->getBaseURL('categories') ?>">Category</a>
</div>