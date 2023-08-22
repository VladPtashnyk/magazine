<?php
    require_once 'app/vendor/Controller.php';
    require_once 'app/models/Users.php';
    require_once 'app/helper/Request.php';
    require_once 'app/models/Product.php';
    require_once 'app/models/Statuses.php';
    require_once 'app/models/Prices.php';
    require_once 'app/models/Orders.php';
    require_once 'app/models/Categories.php';

    class CategoryController extends Controller 
    {
        public function actionCategories()
        {
            $categoryModel = new Categories();
            $categories = $categoryModel->getAll();
            $content = [
                'categories' => $categories,
            ];
            return $this->view('admin/category/categories', $content);
        }
        
        public function actionCreate()
        {
            $categoryModel = new Categories();
            if (!is_null($this->getPost('create'))) {
                $data = $this->getPost();
                $setCategoryData = [
                    'name' => $data['category_name'],
                    'description' => $data['description'],
                ];
                $categoryModel->insert($setCategoryData);
            }
            return $this->view('admin/category/create');
        }

        public function actionDelete()
        {
            //var_dump($requset->checkForm($data));
            $id = $this->getGet('id');
            // var_dump($id);
            // die;
            $categoryModel = new Categories();
            if (!empty($id)) {
                $categoryModel->delete($id);
            }
            return $this->redirect('../categories');
        }
        
        public function actionUpdate()
        {
            $idProduct = $this->getGet('id');
            $priceModel = new Prices();
            $productModel = new Product();
            $statusModel = new Statuses();
            $requset = new Request();
            if (!is_null($this->getPost('update'))) {
                $idProduct = $this->getPost('update');
                $data = $this->getPost();
                $imageName = $requset->saveImg();
                $updateDate = [
                    'name' => $data['product_name'],
                    'description' => $data['description'],
                    'id_status' => $data['product_status'],
                    'quantity' => $data['quantity'],
                    'main_image' => $imageName,
                ];
                $productModel->update($idProduct, $updateDate);
                foreach ($data['price'] as $idPrice => $price) {
                    // echo '<pre>';
                    // var_dump($id);
                    // die;
                    $updatePriceData = [
                        'price' => $price,
                    ];
                    $priceModel->update($idPrice, $updatePriceData);
                }
                foreach ($data['price_status'] as $idPrice => $id_status) {
                    $updatePriceData = [
                        'id_status' => $id_status,
                    ];
                    $priceModel->update($idPrice, $updatePriceData);
                }
                if (!empty($data['newPrice']) && !empty($data['newPriceStatus'])) {
                    $insertPriceData = [
                        'id_product' => $idProduct,
                        'id_status' => $data['newPriceStatus'],
                        'price' => $data['newPrice'],
                    ];
                    $priceModel->insert($insertPriceData);
                }
            }
            if (!empty($idProduct)) {
                $productPrices = $priceModel->getAll(['id_product' => [$idProduct]]);
                $product = $productModel->getOne($idProduct);
            }
            // var_dump($product);
            $allStatus = $statusModel->getAll();
            $productStatuses = $pricesStatuses = [];
            foreach ($allStatus as $status) {
                switch ($status['category']) {
                    case 'Product';
                        $productStatuses[] = $status;
                        break;
                    case 'Price';
                        $pricesStatuses[] = $status;
                        break;
                }
            }
            $content = [
                'productPrices' => $productPrices,
                'product' => $product,
                'pricesStatuses' => $pricesStatuses,
                'productStatuses' => $productStatuses,
            ];

            return $this->view('admin/product/update', $content);
        }

        public function actionOpen() 
        {
            $id = $this->getGet('id');
            $categoryModel = new Categories();
            $category = $categoryModel->getOne($id);

            $content = [
                'category' => $category,
            ];
            /*echo '<pre>';
            var_dump($content);*/
            return $this->view('admin/category/oneCategory', $content);
        }

        public function actionDeletePrice() 
        {
            $id = $this->getGet('id');
            // var_dump($id);
            // die;
            echo '<pre>';
            $priceModel = new Prices();
            $orderModel = new Orders();
            if (!empty($id)) {
                $productPrices = $priceModel->getAll(['id_product' => [$id]]);
                $orderPrices = $orderModel->getAll(['id_product' => [$id]]);
            }
            foreach ($orderPrices as $orders) {
                $idOrder = $orders['id_order'];
                var_dump($idOrder);
                // $orderModel->delete($idOrder);
            }
            foreach ($productPrices as $prices) {
                $idPrice = $prices['id_price'];
                var_dump($idPrice);
                // $priceModel->delete($idPrice);
            }
            return $this->redirect('../products');
        }
    }
?>