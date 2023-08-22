<?php
    require_once 'app/vendor/DataBase.php';
    require_once 'app/vendor/BaseModel.php';

    class SubCategories extends BaseModel
    {
        public $table = 'sub_categories';
        public $primaryKey = 'id_sub_category';
        public $fields = ['id_sub_category', 'id_category', 'name', 'description'];
    }
?>