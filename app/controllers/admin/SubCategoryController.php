<?php
    require_once 'app/vendor/Controller.php';
    require_once 'app/models/Users.php';
    require_once 'app/helper/Request.php';
    require_once 'app/models/Product.php';
    require_once 'app/models/Statuses.php';
    require_once 'app/models/Prices.php';
    require_once 'app/models/Orders.php';
    require_once 'app/models/Categories.php';
    require_once 'app/models/SubCategories.php';

    class SubCategoryController extends Controller 
    {
        public function actionSubCategories()
        {
            $subCategoryModel = new SubCategories();
            $subCategories = $subCategoryModel->getAll();
            $content = [
                'subCategories' => $subCategories,
            ];
            return $this->view('admin/subCategory/subCategories', $content);
        }
        
        public function actionCreate()
        {
            $subCategoryModel = new SubCategories();
            $categoryModel = new Categories();
            $categories = $categoryModel->getAll();
            if (!is_null($this->getPost('create'))) {
                $data = $this->getPost();
                $setSubCategoryData = [
                    'name' => $data['sub_category_name'],
                    'description' => $data['description'],
                    'id_category' => $data['newCategory'],
                ];
                $subCategoryModel->insert($setSubCategoryData);
            }
            $content = [
                'categories' => $categories,
            ];
            return $this->view('admin/subCategory/create', $content);
        }

        public function actionDelete()
        {
            //var_dump($requset->checkForm($data));
            $id = $this->getGet('id');
            // var_dump($id);
            // die;
            $subCategoryModel = new SubCategories();
            if (!empty($id)) {
                $subCategoryModel->delete($id);
            }
            return $this->redirect('../subCategories');
        }
        
        public function actionUpdate()
        {
            $idSubCategory = $this->getGet('id');
            $subCategoryModel = new SubCategories();
            $categoryModel = new Categories();
            $categories = $categoryModel->getAll();
            if (!is_null($this->getPost('update'))) {
                $data = $this->getPost();
                $updateSubCategory = [
                    'id_category' => $data['newCategory'],
                    'name' => $data['sub_category_name'],
                    'description' => $data['description'],
                ];
                $subCategoryModel->update($idSubCategory, $updateSubCategory);
            }
            $categories = $categoryModel->getAll();
            if (!empty($idSubCategory)) {
                $subCategory = $subCategoryModel->getOne($idSubCategory);
            }
            // var_dump($subCategory);
            $content = [
                'subCategory' => $subCategory,
                'categories' => $categories,
            ];

            return $this->view('admin/subCategory/update', $content);
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