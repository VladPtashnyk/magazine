<?php
    require_once 'app/vendor/DataBase.php';
    require_once 'app/vendor/BaseModel.php';

    class Customers extends BaseModel
    {
        public $table = 'customers';
        public $primaryKey = 'id_customer';
        public $fields = ['id_customer', 'id_status', 'first_name', 'second_name', 'phone', 'email', 'password'];
    }
?>