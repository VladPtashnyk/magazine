<?php
    require_once 'app/vendor/DataBase.php';
    require_once 'app/vendor/BaseModel.php';

    class Categories extends BaseModel
    {
        public $table = 'categories';
        public $primaryKey = 'id_category';
        public $fields = ['id_category', 'name', 'description'];
    }
?>