<?php 
    class Controller 
    {
        public function __construct()
        {
            if(session_status() == PHP_SESSION_NONE) {
                session_start();
            };
        }

        public function view ($viewName, $data = []) 
        {
            $viewPath = 'app/resourse/views/'.$viewName.'.php';
            if (file_exists($viewPath)) {
                /*extract($data, EXTR_OVERWRITE) - це функція PHP, 
                яка витягує всі елементи з асоціативного масиву 
                $data і створює змінні з ключами масиву і присвоює їм відповідні значення.*/
                extract($data, EXTR_OVERWRITE);
                include $viewPath;
            } else {
                include_once 'app/resourse/views/templates/404.php';
            }
        }

        protected function render(string $timelate, array $data = [])
        {
            require_once 'app/resourse/views/'.$timelate.'.php';
        }
        
        public function getPost(string $key = null)
        {
            $result = [];

            if (isset($_POST)) {
                $result = $_POST;
                if (!is_null($key)) {
                    if (isset($_POST[$key])) {
                        $result = $_POST[$key];
                    } else if (!isset($_POST[$key])) {
                        $result = null;
                    }
                }
            }

            return $result;
        }

        public function getGet(string $key = null) 
        {
            $result = [];

            if (isset($_GET)) {
                $result = $_GET;
                if (!is_null($key)) {
                    if (isset($_GET[$key])) {
                        $result = $_GET[$key];
                    } else if (!isset($_GET[$key])) {
                        $result = "Errorundefined key: $key";
                    }
                }
            }

            return $result;
        }

        public function redirect(string $url)
        {
            // хедер локейшн виконується зразу, тобто якщо будуть певірки якісь то виконається зразу локейш
            header('Location: ' .$url);
            exit;
        }
        
        public function getBaseURL(string $str = '')
        {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            //var_dump($url);
            if ($url[1] === 'admin') {
                $url[1] .= '/'. $str;
            }
            return !isset($url[2]) ? $url[1] : $str;
        }

        public function getImage(array $data) {
            return $this->view('admin/components/image', $data);
        }

        public function setSession(mixed $data, mixed $value = null) 
        {
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    if (is_int($key)) {
                        $_SESSION[$value] = null;
                    } else {
                        $_SESSION[$key] = $value;
                    }
                }
                return;
            }
            
            $_SESSION[$data] = $value;
        }

        public function getSession(string $key) 
        {
            if (!empty($_SESSION[$key])) {
                return $_SESSION[$key];
            }
        }
    }