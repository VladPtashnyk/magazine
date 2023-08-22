<?php 
    require_once 'app/vendor/BaseModel.php';

    class BaseModel
    {
        protected $dataBaseName = 'magazine_db';
        protected $properties = [];

        public function __construct()
        {
            $this->getChildproperties($this->getInheritedClassName());
        }

        public function getInheritedClassName()
        {
            return get_called_class();
        }

        public function getChildproperties($childModel) 
        {
            $reflection = new ReflectionClass($childModel);
            $properties = $reflection->getProperties();
            foreach ($properties as $property) {
                $this->properties[$property->getName()] = $property->getValue($this);
            }
        }

        public function builder()
        {
            return DataBase::connection();
        }

        public function getAll(array $filters = [])
        {
            $table = $this->properties['table'];
            $primaryKey = $this->properties['primaryKey'];
            $fields = $this->properties['fields'];

            $builder = $this->builder();
            $sql = '';
            if (!empty($filters)) {
                $sql = 'WHERE '.key($filters).' IN(\''.implode(',', $filters[key($filters)]).'\')'; // \' - екранація
            }
            $stmt = $builder->prepare('SELECT '.implode(', ', $fields).' FROM '.$this->dataBaseName.'.'.$table.' '. $sql.''); // Наш запит
            // var_dump('SELECT '.implode(', ', $fields).' FROM '.$this->dataBaseName.'.'.$table.' '. $sql.'');
            // die;
            $stmt->execute(); // Виконує наш запит

            $items = [];
            /*while ($fetch = $stmt->fetch()) {
                $items[$fetch[$idPrimary]] = $fetch;
            }*/

            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                $items[$row[$primaryKey]] = $row;
            }

            return $items;
        }

        /*public function getOne(string $tableName, int $idProduct, string $columnName) 
        {
            $builder = $this->builder();
            $stmt = $builder->prepare('SELECT * FROM '.$this->dataBaseName.'.'.$tableName.' WHERE '.$columnName.' = '.$idProduct.'');
            $stmt->execute();
            return ($stmt->fetchColumn()); 
        }*/

        public function getOne(int $id)
        {
            $table = $this->properties['table'];
            $primaryKey = $this->properties['primaryKey'];
            $fields = $this->properties['fields'];

            $builder = $this->builder();
            $stmt = $builder->prepare('SELECT ' . implode(', ', $fields) . ' FROM magazine_db.' . $table . ' WHERE ' . $primaryKey . ' = ' . $id . '');
            $stmt->execute();

            return $stmt->fetch();
        }

        /*public function insert($data) 
        { 
            $table = $this->properties['table']; 
            $fields = $this->properties['fields']; 
            $params = implode(', :', $fields); 
            $bParams = ':' . implode(', :', $fields); 
            $sql = 'INSERT INTO magazine_db.'.$table.' ('.$params.') VALUES ('.$bParams.')'; 
            // $fields = ['id_user', 'first_name', 'last_name', 'phone', 'id_status']; 
 
            $this->builder() 
                 ->prepare($sql) 
                 ->execute($data); 
        }*/

        public function insert(array $data)
        {
            $table = $this->properties['table'];
            $primaryKey = $this->properties['primaryKey'];
            $fields = $this->properties['fields'];
            //Clean $primaryKey from $fields
            $fields = array_flip($fields);
            unset($fields[$primaryKey]);
            $fields = array_flip($fields);
            //var_dump($data);

            $dbFields = implode(', ', $fields);
            $postFields = ':' . implode(', :', $fields);

            $sql = 'INSERT INTO ' . $this->dataBaseName.'.'. $table . ' (' . $dbFields . ')'. ' VALUES (' . $postFields . ')';
            $this->builder()
                 ->prepare($sql)
                 ->execute($data);

            return $this->builder()->lastInsertId();
            // $this->getInheritedClassName())
        }

        public function delete(int $id)
        {
            //DELETE FROM `statuses` WHERE `statuses`.`id_status` = 11;
            $id = intval($id);
            $table = $this->properties['table']; 
            $primaryKey = $this->properties['primaryKey'];
            $sql = 'DELETE FROM magazine_db.'.$table.' WHERE '.$primaryKey .' = '.$id.''; 

            $this->builder() 
                 ->prepare($sql) 
                 ->execute();
        }

        public function update(int $id, array $data, string $field = '')
        {
            //UPDATE `statuses` SET `name` = 'Товар у відділенніd' WHERE `statuses`.`id_status` = 6;
            $table = $this->properties['table'];
            $primaryKey = $this->properties['primaryKey'];
            $id = intval($id);

            $updatefields = '';
            foreach ($data as $key => $val) {
                $updatefields .= $key. "='". $val . "',";
            }
            $updatefields = rtrim($updatefields, ', ');
            $where = !empty($field) ? $field : $primaryKey;
            $sql = 'UPDATE '.$this->dataBaseName.'.'.$table.' SET '.$updatefields.' WHERE '.$where.' = '.$id.'';
            // var_dump($sql);
            // die;
            /*$sql = '';
            foreach ($data as $key => $value) {
                $sql = 'UPDATE '.$this->dataBaseName.'.'.$table.' SET '.$key.' = '.$value.' WHERE '.$primaryKey.' = '.$id.'';
            }*/
            $this->builder()
                 ->prepare($sql)
                 ->execute();
        }

        public function addFilters(string $sql) 
        {
            $sqlFilters = '';
            if (str_contains($sql, 'WHERE')) {
                $sqlFilters = ' AND ';
            } else {
                $sqlFilters = ' WHERE ';
            }

            return $sqlFilters;
        }
    }
?>