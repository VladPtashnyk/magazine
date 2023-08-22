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

    class ProductController extends Controller 
    {
        public function actionProducts()
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
            // var_dump($this->getSession('filters'));
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
            return $this->view('admin/product/products', $content);
        }
        
        public function actionCreate()
        {
            $statusModel = new Statuses();
            $productModel = new Product();
            $priceModel = new Prices();
            $requsetModel = new Request();
            $categoryModel = new Categories();
            $productCategoryModel = new ProductsCategories();
            $allStatus = $statusModel->getAll();
            $categories = $categoryModel->getAll();
            $pricesStatuses = $productStatuses = [];
            //var_dump($requset->checkForm($data));
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
            if (!is_null($this->getPost('create'))) {
                $data = $this->getPost();
                $setProductData = [
                    'id_status' => $data['product_status'],
                    'name' => $data['product_name'],
                    'description' => $data['description'],
                    'main_image' => $requsetModel->saveImg(),
                    'quantity' => $data['quantity']
                ];
                //$productModel->insert($setProductData);
                $idProduct = $productModel->insert($setProductData);
                if (!empty($idProduct)) {
                    $setPriceData = [
                        'id_status' => $data['price_status'],
                        'id_product' => $idProduct,
                        'price' => $data['product_price'],
                    ];
                    $priceModel->insert($setPriceData);
                }
                if (!empty($data['newCategory'])) {
                    $setProductCategories = [
                        'id_category' => $data['newCategory'],
                        'id_product' => $idProduct,
                    ];
                    $productCategoryModel->insert($setProductCategories);
                }
            }
            $content = [
                'productStatuses' => $productStatuses,
                'pricesStatuses' => $pricesStatuses,
                'categories' => $categories,
            ];
            return $this->view('admin/product/create', $content);
        }

        public function actionDelete()
        {
            //var_dump($requset->checkForm($data));
            $id = $this->getGet('id');
            // var_dump($id);
            // die;
            $priceModel = new Prices();
            $productModel = new Product();
            $orderModel = new Orders();
            if (!empty($id)) {
                $productPrices = $priceModel->getAll(['id_product' => [$id]]);
                $orderPrices = $orderModel->getAll(['id_product' => [$id]]);
                $product = $productModel->getOne($id);
                $productImage = $product['main_image'];
                $dir = 'app/resourse/uploads/'.$productImage;
            }
            foreach ($orderPrices as $orders) {
                $idOrder = $orders['id_order'];
                $orderModel->delete($idOrder);
            }
            foreach ($productPrices as $prices) {
                $idPrice = $prices['id_price'];
                $priceModel->delete($idPrice);
            }
            $productModel->delete($id);
            unlink($dir);
            return $this->redirect('../products');
        }
        
        public function actionUpdate()
        {
            $idProduct = $this->getGet('id');
            $priceModel = new Prices();
            $productModel = new Product();
            $statusModel = new Statuses();
            $requset = new Request();
            $categoryModel = new Categories();
            $productCategoryModel = new ProductsCategories();
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
                $productCategoryModel->update($idProduct, ['id_category' => $data['newCategory']], 'id_product');
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
                        'active' => 0,
                    ];
                    $priceModel->update($idPrice, $updatePriceData);
                }
                $idPriceActive = $this->getPost('active');
                if (!empty($idPriceActive)) {
                    $updatePriceData = [
                        'active' => 1,
                    ];
                    $priceModel->update($idPriceActive, $updatePriceData);
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
            if (!empty($this->getPost('deletePrice'))) {
                $priceModel->delete($this->getPost('deletePrice'));
            }
            if (!empty($idProduct)) {
                $productPrices = $priceModel->getAll(['id_product' => [$idProduct]]);
                $product = $productModel->getOne($idProduct);
            }
            // var_dump($product);
            $categories = $categoryModel->getAll();
            $allStatus = $statusModel->getAll();
            $productsCategory = $productCategoryModel->getAll(['id_product' => [$idProduct]]);
            foreach ($productsCategory as $productCategory) {
                $idCategory = $productCategory['id_category'];
            }
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
                'productsCategory' => $productsCategory,
                'categories' => $categories,
                'idCategory' => $idCategory,
            ];

            return $this->view('admin/product/update', $content);
        }

        public function actionOpen() 
        {
            $id = $this->getGet('id');
            $productModel = new Product();
            $priceModel = new Prices();
            $statusModel = new Statuses();
            $product = $productModel->getOne($id);
            $prices = $priceModel->getAll(['id_product' => [$id]]);
            $productStatus = $statusModel->getOne($product['id_status']);
            $idsPriceStatus = array_column($prices, 'id_status');
            $priceStatus = $statusModel->getAll(['id_status' => $idsPriceStatus]);

            //var_dump($prices);
            $content = [
                'product' => $product,
                'productStatus' => $productStatus,
                'prices' => $prices,
                'pricesStatus' => $priceStatus,
            ];
            /*echo '<pre>';
            var_dump($content);*/
            return $this->view('admin/product/oneProduct', $content);
        }

        public function actionDeletePrice() 
        {
            $priceModel = new Prices();
            if (!empty($id)) {
                $productPrices = $priceModel->getAll(['id_product' => [$id]]);
            }
            foreach ($productPrices as $prices) {
                $idPrice = $prices['id_price'];
                //var_dump($idPrice);
                // $priceModel->delete($idPrice);
            }
            return $this->redirect('../update');
        }
    }
?>