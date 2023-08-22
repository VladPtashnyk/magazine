<?php
    require_once 'app/vendor/Controller.php';
    require_once 'app/models/Users.php';
    require_once 'app/helper/Request.php';
    require_once 'app/models/Product.php';
    require_once 'app/models/Statuses.php';
    require_once 'app/models/Prices.php';
    require_once 'app/models/Orders.php';
    require_once 'app/models/Categories.php';
    require_once 'app/models/ProductsCategories.php';
    require_once 'app/models/SubCategories.php';
    require_once 'app/models/Customers.php';

    class HomeController extends Controller
    {
        public function actionIndex()
        {
            $productModel = new Product();
            $categoryModel = new Categories();
            $statusModel = new Statuses();
            $subCategoryModel = new SubCategories();
            // echo '<pre>';
            // var_dump($allProducts);
            // die;
            $filters = [
                'id_category' => 0,
                'price' => [],
                'id_status' => 0,
                'productName' => '',
                'subCategory' => 0
            ];
            $idCategory = $this->getPost('id_category');
            $price = $this->getPost('price');
            $resetFilters = $this->getPost('resetFilters');
            $idStatus = $this->getPost('id_status');
            $productName = $this->getPost('product_name');
            $idSubCategory = $this->getPost('id_sub_category');
            if (!empty($idCategory)) {
                $filters['id_category'] = $idCategory;
            }
            // var_dump($filters['id_category']);
            if (!empty($filters['id_category'])) {
                $this->setSession('filters', $filters);
            }
            if (!empty($price)) {
                $filters['price'] = $price;
            }
            if (!empty($filters['price'])) {
                $this->setSession('filters', $filters);
                //var_dump($_SESSION);
            }
            if (!empty($resetFilters)) {
                unset($_SESSION['filters']);
            }
            if (!empty($idStatus)) {
                $filters['id_status'] = $idStatus;
            }
            if (!empty($filters['id_status'])) {
                $this->setSession('filters', $filters);
            }
            if (!empty($productName)) {
                $filters['productName'] = $productName;
            }
            if (!empty($filters['productName'])) {
                $this->setSession('filters', $filters);
            }
            if (!empty($idSubCategory)) {
                $filters['idSubCategory'] = $idSubCategory;
            }
            if (!empty($filters['idSubCategory'])) {
                $this->setSession('filters', $filters);
            }
            if (!empty($this->getSession('filters'))) {
                $filters = array_merge($filters, $this->getSession('filters'));
            }

            $idProductBasket = $this->getPost('basket');
            $userIP = $_SERVER['REMOTE_ADDR'];
            if (!isset($_SESSION['user'][$userIP]['basket'])) {
                $_SESSION['user'][$userIP]['basket'] = [];
            }
            if (!empty($idProductBasket)) {
                if (!isset($_SESSION['user'][$userIP]['basket'][$idProductBasket]['count'])) {
                    $_SESSION['user'][$userIP]['basket'][$idProductBasket]['count'] = 0;
                }
                $_SESSION['user'][$userIP]['basket'][$idProductBasket]['count']++;
                // var_dump($this->getSession('filters'));
            }

            $allCategories = $categoryModel->getAll();
            $allStatus = $statusModel->getAll(['category' => ['product']]);
            $allProducts = $productModel->getAllProduct($filters);
            $allSubCategories = $subCategoryModel->getAll();
            $content = [
                'allProducts' => $allProducts,
                'allCategories' => array_merge([0 => ['id_category' => 0, 'name' => 'AllCategories']], $allCategories),
                'filters' => $filters,
                'allStatus' => array_merge([0 => ['id_status' => 0, 'name' => 'AllStatuses']], $allStatus),
                'allSubCategories' => array_merge([0 => ['id_sub_category' => 0, 'name' => 'AllSubCategories']], $allSubCategories),
            ];

            return $this->view('home/index', $content);
        }

        public function actionBasket() 
        {
            $productModel = new Product();
            
            $userIP = $_SERVER['REMOTE_ADDR'];
            if (!isset($_SESSION['user'][$userIP]['basket'])) {
                $_SESSION['user'][$userIP]['basket'] = [];
            }
            $idRemoveBasket = $this->getPost('removeBasket');
            if (!empty($idRemoveBasket)) {
                if ($idRemoveBasket == 'yes') {
                    unset($_SESSION['user'][$userIP]['basket']);
                } else {
                    unset($_SESSION['user'][$userIP]['basket'][$idRemoveBasket]);
                }
            }
            // var_dump($_SESSION['user'][$userIP]['basket']);
            $productIds = [];
            $productCounts = [];
            foreach ($_SESSION['user'][$userIP]['basket'] as $idProduct => $countArray) {
                $productIds[$idProduct] = $idProduct;
                $productCounts[$idProduct] = $countArray;
            }
            // var_dump($_SESSION);

            $filters = [
                'idsProduct' => [],
            ];
            if (!empty($productIds)) {
                $filters['idsProduct'] = $productIds;
                // var_dump($filters);
            }

            if (!empty($filters['idsProduct'])) {
                $basketProducts = $productModel->getAllProduct($filters);
                foreach ($basketProducts as $idProduct => $product) {
                    foreach ($productCounts as $idProductCount => $countArray) {
                        if ($idProduct === $idProductCount) {
                            $basketProducts[$idProduct]['count'] = $countArray['count'];
                            $basketProducts[$idProduct]['totalPrice'] = $countArray['count'] * $basketProducts[$idProduct]['price'];
                        }
                    }
                }
                // echo '<pre>';
                // var_dump($basketProducts);

                $content = [
                    'basketProducts' => $basketProducts,
                ];

                $_SESSION['basketProducts'] = $basketProducts;
            }

            return $this->view('home/basket', $content);
        }

        public function actionCreateOrder()
        {
            $customerModel = new Customers();
            $orderModel = new Orders();

            if (!empty($this->getPost('phone'))) {
                $customerPhone = $this->getPost('phone');
                $customerEmail = $this->getPost('email');
                $customerName = $this->getPost('name');
                $customerSecondName = $this->getPost('second_name');
                $setCustomerData = [
                    'id_status' => 30,
                    'first_name' => $customerName,
                    'second_name' => $customerSecondName,
                    'phone' => $customerPhone,
                    'email' => $customerEmail,
                    'password' => null
                ];
                $idCustomer = $customerModel->insert($setCustomerData);
                foreach ($_SESSION['basketProducts'] as $order) {
                    // echo '<pre>';
                    // var_dump($order);
                    // die;
                    $setOrderData = [
                        'id_product' => $order['id_product'],
                        'id_customer' => $idCustomer,
                        'id_status' => 29,
                        'id_user' => 29,
                        'total_price' => $order['totalPrice'],
                        'total_quantity' => $order['count']
                    ];
                    $orderModel->insert($setOrderData);
                }
            }

            if (!empty($_SESSION['basketProducts'])) {
                $content = [
                    'basketProducts' => $_SESSION['basketProducts'],
                ];
            }
            return $this->view('home/order', $content);
        }
    }