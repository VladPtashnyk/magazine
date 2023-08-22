<?php
    require_once 'app/vendor/DataBase.php';
    require_once 'app/vendor/BaseModel.php';
    require_once 'app/vendor/Controller.php';

    class Users extends BaseModel
    {
        public $table = 'users';
        public $primaryKey = 'id_user';
        public $fields = ['id_user', 'first_name', 'second_name', 'phone', 'id_status'];

        public function getAllUser()
        {
            $users = $this->getAll();
            return $users;
        }

        public function login()
        {
            /*if (isset($_POST['phone']) && isset($_POST['passwordUser'])) {
                $_SESSION['login']['phone'] = $_POST['phone'];
                $password = md5($_POST['passwordUser']);
                $_SESSION['login']['password'] = $password;
                var_dump(trim($password, "\"'"));
                $perevirk = 'magazine_db.users.password = '.stripslashes($password).'';
                $sql = ('SELECT * FROM magazine_db.users WHERE phone = '.$_SESSION['login']['phone'].' AND magazine_db.users.password = '.trim($password, "\"'").'');
                $stmt = $this->builder()
                            ->prepare($sql);
            }
            return ($stmt->fetchColumn());*/

            /*if (isset($_POST['phone']) && isset($_POST['passwordUser'])) {
                $_SESSION['login']['phone'] = $_POST['phone'];
                $password = md5($_POST['passwordUser']);
                $_SESSION['login']['password'] = $password;
                $password = trim($password, "\"'");
                $sql = 'SELECT * FROM magazine_db.users WHERE phone = :phone AND magazine_db.users.password = :password';
                $stmt = $this->builder()
                    ->prepare($sql);
                $stmt->execute([
                    ':phone' => $_SESSION['login']['phone'],
                    ':password' => $password
                ]);
                return $stmt->fetchColumn();
            }*/

            $controller = new Controller;
            //isset($controller->getPost('phone')) && isset($controller->getPost('passwordUser'))
            $password = md5($controller->getPost('passwordUser'));
            $sql = 'SELECT * FROM magazine_db.users WHERE phone = :phone AND magazine_db.users.password = :password';
            $stmt = $this->builder()
                ->prepare($sql);
            $stmt->execute([
                ':phone' => $controller->getPost('phone'),
                ':password' => $password
            ]);
            //var_dump($stmt->fetchColumn());
            
            return $stmt->fetchColumn();
        }

        /*public function save(array $data)
        {
            if (isset($data['firstName']) && isset($data['secondName']) && isset($data['phone']) && isset($data['email']) && isset($data['password']) && isset($data['id_status'])) {
                $password = md5($data['password']);

                $sql = ('INSERT INTO magazine_db.users (first_name, second_name, phone, email, password, id_status) 
                VALUES (:first_name, :second_name, :phone, :email, :password, :id_status)');
                $stmt = $this->builder()
                             ->prepare($sql);
                $stmt->bindParam(':first_name', $data['firstName']);
                $stmt->bindParam(':second_name', $data['secondName']);
                $stmt->bindParam(':phone', $data['phone']);
                $stmt->bindParam(':email', $data['email']);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':id_status', $data['id_status']);

                return $stmt->execute();
            }
        }*/

        public function save(array $data)
        {
            if (!empty($data['firstName']) && !empty($data['secondName']) && !empty($data['phone']) && !empty($data['email']) && !empty($data['password']) && !empty($data['id_status'])) {
                $password = md5($data['password']);

                $sql = 'INSERT INTO magazine_db.users (first_name, second_name, phone, email, password, id_status) 
                        VALUES (:first_name, :second_name, :phone, :email, :password, :id_status)';
                $stmt = $this->builder()
                    ->prepare($sql);
                $stmt->bindParam(':first_name', $data['firstName']);
                $stmt->bindParam(':second_name', $data['secondName']);
                $stmt->bindParam(':phone', $data['phone']);
                $stmt->bindParam(':email', $data['email']);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':id_status', $data['id_status']);

                return $stmt->execute();
            }
        }
    }
?>