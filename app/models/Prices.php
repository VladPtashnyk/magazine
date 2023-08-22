<?php
    require_once 'app/vendor/DataBase.php';
    require_once 'app/vendor/BaseModel.php';

    class Prices extends BaseModel
    {
        public $table = 'prices';
        public $primaryKey = 'id_price';
        public $fields = ['id_price', 'id_product', 'price', 'id_status', 'active'];
    }
?>