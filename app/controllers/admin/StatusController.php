<?php
    require_once 'app/vendor/Controller.php';
    require_once 'app/models/Users.php';
    require_once 'app/helper/Request.php';
    require_once 'app/models/Statuses.php';
    require_once 'app/vendor/BaseModel.php';

    class StatusController extends Controller
    {
        public function actionStatus()
        {
            $statusModel = new Statuses();
            $allStatuses = $statusModel->getAll();
            $content = [
                'allStatuses' => $allStatuses,
            ];
            return $this->view('admin/status/status', $content);
        }
        
        public function actionCheck()
        {
            //var_dump($this->getPost());
            $post = $this->getPost();
            if (isset($post['update'])) {
                $this->actionUpdate($post);
            } elseif (isset($post['delete'])) {
                $this->actionDelete($post['delete']);
            } elseif (isset($post['create'])) {
                $this->actionCreate($post);
            }
        }
        
        public function actionCreate(array $data)
        {
            $requset = new Request();
            $statusModel = new Statuses();
            //var_dump($requset->checkForm($data));
            $setStatusData = [
                'name' => $data['name'],
                'category' => $data['category'],
            ];
            if (empty($requset->checkForm($setStatusData))) {
                $statusModel->insert($setStatusData);
            }
            $this->redirect('../status');   
        }

        public function actionDelete(int $id)
        {
            $statusModel = new Statuses();
            if ($this->getPost('delete')) {
                //$statusId = $this->getPost('delete');
                $statusModel->delete($id);
            }
            $this->redirect('../status');
        }


        public function actionUpdate(array $data = [])
        {
            //var_dump($data);
            //UPDATE `statuses` SET `name` = 'Товар у відділенніd' WHERE `statuses`.`id_status` = 6;
            $statusModel = new Statuses();
            $setStatusData = [
                'name' => $data['name'],
                'category' => $data['category'],
            ];
            $statusModel->update($data['id_status'], $setStatusData);
            //var_dump($this->getPost('name'));
            return $this->redirect('../status');
        }
    }
?>