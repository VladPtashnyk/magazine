<?php
    require_once 'app/vendor/Controller.php';
    require_once 'app/models/Users.php';
    require_once 'app/helper/Request.php';

    class AdminController extends Controller 
    {
        public function actionIndex() {
            if (!empty($_SESSION['adminUser'])) {
                return $this->view('admin/dashboard/dashboard');
                //return $this->redirect('dashboard');
            } else {
                return $this->actionLogin();
            }
        }

        public function actionLogin() {
            $this->logOut();
            $userModel = new Users();
            $userData = $this->getPost();
            if (!empty($userData['phone']) && !empty($userData['passwordUser'])) {
                $login = $userModel->login();
                if (!is_bool($login)) {
                    $_SESSION['adminUser'] = 'yes';
                    $this->actionIndex();
                }
            }
            return $this->view('admin/login/login');
        }

        public function actionRegister() {
            $userModel = new Users();
            $request = new Request();

            $userData = $this->getPost();
            $content = [];
            $s = $request->checkRegister($userData);
            if (!empty($userData)) {
                $errors = $request->checkForm($userData);
                var_dump($errors);
                if (!empty($errors)) {
                    $content['errors'] = $errors;
                } else {
                    if ($s == false) {
                        $userModel->save($userData);
                        $this->actionLogin();
                    }
                }
            }
            return $this->view('admin/register/register', $content);
        }

        public function logOut() 
        {
            session_destroy();
        }
    }
?>