<?php
    namespace vendor;

    use Controller;

    require_once 'app/vendor/Controller.php';

    class Route
    {
        private $uri;
        private $controllerName = 'Index';
        private $actionName = 'Index';
        private $route;
        private $dirController = 'app/controllers/';

        public function startApp() 
        {
            $this->setUri();
            $this->setRoute();
            $this->setRouteParams();
            $this->redirect();
        }

        public function setUri()  // налаштовуємо те що зараз в нас в url
        {
            $this->uri = $_SERVER['REQUEST_URI'];
            $this->uri = trim($this->uri, '/');
        }

        private function setRoute()        // розбиваємо на url та get пфраметри
        {
            $this->route = explode('?', $this->uri);
        }

        private function setRouteParams() // читає наші action і controller
        {
            global $urlRoutes;
            if (isset($urlRoutes[$this->route[0]])) {
                $routePath = explode('/', $urlRoutes[$this->route[0]]);
                if (isset($routePath[0]) && isset($routePath[1])) {
                    $actionName = $routePath[1];
                    $this->setControllerName($routePath[0]);
                    // if ($routePath[0] == 'admin') {
                        $actionName = $routePath[2];
                        $this->dirController .= $routePath[0] .'/';
                        $this->setControllerName($routePath[1]);
                    // }
                }
                $this->setActionName($actionName);
            } 
        }

        private function setControllerName($name) // налаштовуємо ім'я нашого контролера
        {
            $this->controllerName = ucfirst($name).'Controller';
        }

        private function setActionName($name)   // налаштовуємо ім'я нашого екшна(action)
        {
            $this->actionName = 'action'.ucfirst($name);
        }

        private function redirect()
        {
            $dir = $this->dirController.$this->controllerName.'.php';
            if (is_null($this->checkDirExist($dir))) {
                $controller = $this->checkClassExists($this->controllerName);
                if (!is_null($controller)) {
                    $this->checkMethodExists($controller, $this->actionName);
                }
            }

        }

        private function checkDirExist(string $dir)
        {
            $error = null;
            $baseController = new Controller();
            if (file_exists($dir)) {
                require_once $dir;
            } else {
                $error = 'This controller doesn`t found';
                $baseController->view('templates/404', ['error' => $error]);
            } 

            return $error;
        }

        private function checkClassExists(string $controllerName)
        {
            $baseController = new Controller();
            $error = $controller = null;
            if (class_exists($this->controllerName)) {
                $controller = new $this->controllerName();
            } else {
                $error = 'This class doesn`t found';
                $baseController->view('templates/404', ['error' => $error]);
            }

            return is_null($error) ? $controller : null;
        }

        private function checkMethodExists(object $controller, string $actionName)
        {
            $baseController = new Controller();
            $error = null;
            if (method_exists($controller, $this->actionName)) {
                $controller->$actionName();                
            } else {
                $error = 'This action doesn`t found';
                $baseController->view('templates/404', ['error' => $error]);
            }
        }
    }
?>