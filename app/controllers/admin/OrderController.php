<?php
    require_once 'app/vendor/Controller.php';
    require_once 'app/models/Users.php';
    require_once 'app/helper/Request.php';
    require_once 'app/models/Statuses.php';
    require_once 'app/vendor/BaseModel.php';
    require_once 'app/models/Orders.php';

    class OrderController extends Controller
    {
        public function actionOrder()
        {
            $orderModel = new Orders();
            $statusModel = new Statuses();
            $userModel = new Users();
            $allOrders = $orderModel->getAllOrders();
            $allStatuses = $statusModel->getAll(['category' => ['order']]);
            $allStatuses = $statusModel->getAll(['category' => ['order']]);


            // echo '<pre>';
            // var_dump($allStatuses);
            $content = [
                'allOrders' => $allOrders,
                'allStatuses' => $allStatuses,
            ];
            return $this->view('admin/order/order', $content);
        }

        
        // public function actionCheck()
        // {
        //     //var_dump($this->getPost());
        //     $post = $this->getPost();
        //     if (isset($post['update'])) {
        //         $this->actionUpdate($post);
        //     } elseif (isset($post['delete'])) {
        //         $this->actionDelete($post['delete']);
        //     } elseif (isset($post['create'])) {
        //         $this->actionCreate($post);
        //     }
        // }
        
        // public function actionCreate(array $data)
        // {
        //     $requset = new Request();
        //     $statusModel = new Statuses();
        //     //var_dump($requset->checkForm($data));
        //     $setStatusData = [
        //         'name' => $data['name'],
        //         'category' => $data['category'],
        //     ];
        //     if (empty($requset->checkForm($setStatusData))) {
        //         $statusModel->insert($setStatusData);
        //     }
        //     $this->redirect('../status');   
        // }

        // public function actionDelete(int $id)
        // {
        //     $statusModel = new Statuses();
        //     if ($this->getPost('delete')) {
        //         //$statusId = $this->getPost('delete');
        //         $statusModel->delete($id);
        //     }
        //     $this->redirect('../status');
        // }


        // public function actionUpdate(array $data = [])
        // {
        //     //var_dump($data);
        //     //UPDATE `statuses` SET `name` = 'Товар у відділенніd' WHERE `statuses`.`id_status` = 6;
        //     $statusModel = new Statuses();
        //     $setStatusData = [
        //         'name' => $data['name'],
        //         'category' => $data['category'],
        //     ];
        //     $statusModel->update($data['id_status'], $setStatusData);
        //     //var_dump($this->getPost('name'));
        //     return $this->redirect('../status');
        // }
    }
?>