<?php
    require_once 'app/vendor/Controller.php';

    class Request extends BaseModel
    {
        public function checkForm(array $formData)
        {
            $errors = [];

            foreach ($formData as $key => $field) {
                if (empty($field)) {
                    $errors[$key]['desc'] = 'This field is required';
                    $errors[$key]['check'] = true;
                }
            }

            return $errors;
        }

        public function checkRegister(array $formData)
        {
            if (isset ($formData['phone'])) {
                $sql = 'SELECT * FROM magazine_db.users WHERE phone = '.$formData['phone'].'';
                $stmt = $this->builder()
                             ->prepare($sql);
                $stmt->execute();
                return $stmt->fetchColumn();
            }
        }

        /*public function checkLogin()
        {
            $controller = new Controller;
            if (isset($_POST['phone']) && isset($_POST['passwordUser'])) {
                $password = md5($controller->getPost('passwordUser'));
                $sql = 'SELECT * FROM magazine_db.users WHERE phone = :phone AND magazine_db.users.password = :password';
                $stmt = $this->builder()
                    ->prepare($sql);
                $stmt->execute([
                    ':phone' => $controller->getPost('phone'),
                    ':password' => $password
                ]);
                return $stmt->fetchColumn();
            }
        }*/

        public function saveImg() {
            $photoName = $_FILES['fileName']['name'];
            /*var_dump($photoName);
            die;*/
            $photo = explode('.', $photoName);
            $photo[0] = $_POST['product_name'];
            $photoName = implode('.', $photo);
            $dir = 'app/resourse/uploads';
            move_uploaded_file($_FILES['fileName']['tmp_name'], $dir.'/'.$photoName);

            return $photoName;
        }
    }
?>