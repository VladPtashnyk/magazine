<?php
    require_once 'app/vendor/DataBase.php';
    require_once 'app/vendor/BaseModel.php';

    class Orders extends BaseModel
    {
        public $table = 'orders';
        public $primaryKey = 'id_order';
        public $fields = ['id_order', 'id_product', 'id_customer', 'id_status', 'id_user', 'total_price', 'total_quantity'];

        public function getAllOrders()
        {
            $sql = 'SELECT 
            u.first_name AS user_name, 
            u.second_name AS user_second_name, 
            p.id_product, 
            p.name AS product_name, 
            p.main_image AS product_image, 
            c.id_customer,
            c.first_name AS customer_name,
            c.second_name AS customer_second_name,
            c.phone AS customer_phone,
            c.email AS customer_email,
            prs.id_status AS status_id_status,
            prs.name AS status_name, 
            prs.category AS status_category, 
            o.id_order,
            o.id_customer, 
            o.id_user,
            o.id_product, 
            o.id_status AS order_id_status,
            o.total_quantity,
            o.total_price
            FROM '.$this->dataBaseName.'.orders AS o
                  LEFT JOIN '.$this->dataBaseName.'.statuses as prs ON prs.id_status = o.id_status
                  LEFT JOIN '.$this->dataBaseName.'.products as p ON p.id_product = o.id_product
                  LEFT JOIN '.$this->dataBaseName.'.users AS u ON u.id_user = o.id_user
                  LEFT JOIN '.$this->dataBaseName.'.customers as c ON c.id_customer = o.id_customer';

            // if (!empty($filter['idsProduct'])) {
            //     $sql .= ' WHERE pr.id_order IN ('. implode(',', $filter['idsProduct']) .')';
            // }
            // echo '<pre>';
            // var_dump($sql);
            // die;
            $stmt = $this->builder()
                ->query($sql);
            $orders = $stmt->fetchAll(); 
    
            $prepareOrders = [];
            foreach ($orders as $order) {
                // echo '<pre>';
                // var_dump($allProducts);
                // die;
                $prepareOrders[$order['id_order']]['id_order'] = $order['id_order'];
                $prepareOrders[$order['id_order']]['order_id_status'] = $order['order_id_status'];
                $prepareOrders[$order['id_order']]['id_product'] = $order['id_product'];
                $prepareOrders[$order['id_order']]['product_name'] = $order['product_name'];
                $prepareOrders[$order['id_order']]['product_image'] = $order['product_image'];
                $prepareOrders[$order['id_order']]['total_quantity'] = $order['total_quantity'];
                $prepareOrders[$order['id_order']]['total_price'] = $order['total_price'];
                $prepareOrders[$order['id_order']]['status_id_status'] = $order['status_id_status'];
                $prepareOrders[$order['id_order']]['status_name'] = $order['status_name'];
                $prepareOrders[$order['id_order']]['status_category'] = $order['status_category'];
                $prepareOrders[$order['id_order']]['id_user'] = $order['id_user'];
                $prepareOrders[$order['id_order']]['user_name'] = $order['user_name'];
                $prepareOrders[$order['id_order']]['user_second_name'] = $order['user_second_name'];
                $prepareOrders[$order['id_order']]['id_customer'] = $order['id_customer'];
                $prepareOrders[$order['id_order']]['customer_name'] = $order['customer_name'];
                $prepareOrders[$order['id_order']]['customer_second_name'] = $order['customer_second_name'];
                $prepareOrders[$order['id_order']]['customer_phone'] = $order['customer_phone'] ?? '';
                $prepareOrders[$order['id_order']]['customer_email'] = $order['customer_email'] ?? '';
            }

            return $prepareOrders;
        }
    }

?>