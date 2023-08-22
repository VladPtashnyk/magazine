<?php
    require_once 'app/vendor/DataBase.php';
    require_once 'app/vendor/BaseModel.php';

    class ProductsCategories extends BaseModel
    {
        public $table = 'products_categories';
        public $primaryKey = 'id_product_category';
        public $fields = ['id_product_category', 'id_product', 'id_category'];
    }
?>