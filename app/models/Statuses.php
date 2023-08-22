<?php
    require_once 'app/vendor/DataBase.php';
    require_once 'app/vendor/BaseModel.php';

    class Statuses extends BaseModel
    {
        public $table = 'statuses';
        public $primaryKey = 'id_status';
        public $fields = ['id_status', 'name', 'category'];

        /*public function saveStatus(array $data)
        {
            if (!empty($data['status_name']) && !empty($data['status_category'])) {

                $sql = 'INSERT INTO magazine_db.statuses (name, category) 
                        VALUES (:name, :category)';
                $stmt = $this->builder()
                    ->prepare($sql);
                $stmt->bindParam(':name', $data['status_name']);
                $stmt->bindParam(':category', $data['status_category']);

                return $stmt->execute();
            }
        }*/
    }
?>