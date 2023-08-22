<?php
    require_once 'app/vendor/DataBase.php';
    require_once 'app/vendor/BaseModel.php';
    require_once 'app/models/Prices.php';

    class Product extends BaseModel
    {
        public $table = 'products';
        public $primaryKey = 'id_product';
        public $fields = ['id_product', 'name', 'description', 'quantity', 'id_status', 'main_image'];

        public function getAllProduct(array $filter = [])
        {
            $sql = 'SELECT 
            ps.name AS price_name_status, 
            prs.name AS product_name_status, 
            sbc.name AS sub_category_name,
            c.name AS category_name,
            c.id_category,
            p.id_status AS price_id_status, 
            p.id_price,
            p.price, 
            p.active,
            pr.id_product, 
            pr.id_status AS product_id_status,
            pr.name,
            pr.description,
            pr.main_image,
            pr.quantity
            FROM '.$this->dataBaseName.'.products AS pr
                  LEFT JOIN '.$this->dataBaseName.'.statuses as prs ON prs.id_status = pr.id_status
                  LEFT JOIN '.$this->dataBaseName.'.prices AS p ON pr.id_product = p.id_product
                  LEFT JOIN '.$this->dataBaseName.'.statuses as ps ON ps.id_status = p.id_status
                  LEFT JOIN '.$this->dataBaseName.'.products_categories as pc ON pc.id_product = pr.id_product
                  LEFT JOIN '.$this->dataBaseName.'.categories as c ON c.id_category = pc.id_category
                  LEFT JOIN '.$this->dataBaseName.'.sub_categories as sbc ON sbc.id_category = c.id_category';
        
            if (!empty($filter['id_category'])) {
                $sql .= $this->addFilters($sql) . 'c.id_category = '.$filter['id_category'] .'';
            }
            if (!empty($filter['price'])) {
                if (!empty($filter['price']['min'])) {
                    $sql .= $this->addFilters($sql) . 'p.price >='. $filter['price']['min'] .'';
                }
                if (!empty($filter['price']['max'])) {
                    $sql .= $this->addFilters($sql) . 'p.price <='. $filter['price']['max'] .'';
                }
            }
            if (!empty($filter['id_status'])) {
                $sql .= $this->addFilters($sql) . 'prs.id_status = '.$filter['id_status'] .'';
            }
            if (!empty($filter['productName'])) {
                $sql .= $this->addFilters($sql) . 'pr.name LIKE (\'%'.$filter['productName'] .'%\')';
            }
            if (!empty($filter['idSubCategory'])) {
                $sql .= $this->addFilters($sql) . 'sbc.id_sub_category = '.$filter['idSubCategory'] .'';
            }
            if (!empty($filter['idsProduct'])) {
                $sql .= ' WHERE pr.id_product IN ('. implode(',', $filter['idsProduct']) .')';
            }
            $stmt = $this->builder()
                 ->query($sql);
            $allProducts = $stmt->fetchAll(); 

            $prepareProducts = [];
            foreach ($allProducts as $product) {
                // echo '<pre>';
                // var_dump($allProducts);
                // die;
                $prepareProducts[$product['id_product']]['id_product'] = $product['id_product'];
                $prepareProducts[$product['id_product']]['name'] = $product['name'];
                $prepareProducts[$product['id_product']]['description'] = $product['description'];
                $prepareProducts[$product['id_product']]['main_image'] = $product['main_image'];
                $prepareProducts[$product['id_product']]['quantity'] = $product['quantity'];
                $prepareProducts[$product['id_product']]['product_name_status'] = $product['product_name_status'];
                $prepareProducts[$product['id_product']]['prices']['price_id_status'] = [$product['price_name_status'] => $product['price']];
                $prepareProducts[$product['id_product']]['id_category'] = $product['id_category'];
                $prepareProducts[$product['id_product']]['category_name'] = $product['category_name'];
                $prepareProducts[$product['id_product']]['sub_category_name'][] = $product['sub_category_name'];
                // $prepareProducts[$product['id_product']]['price'] = $product['active'] ? $product['price'] : '';
                // $prepareProducts[$product['id_product']]['active'] = $product['active'] ? $product['active'] : '';
                if ($product['active']) {
                    $prepareProducts[$product['id_product']]['price'] = $product['price'];
                } elseif (!isset($prepareProducts[$product['id_product']]['price'])) {
                    $prepareProducts[$product['id_product']]['price'] = '';
                }
                
                // $prepareProducts[$product['id_product']]['prices'][] = $product['price'];
            }
            // echo '<pre>';
            // var_dump($prepareProducts);
            // die;
            
            /*foreach ($products as $product) {
                $builder = $this->builder();
                $stmt = $builder->prepare('SELECT * FROM magazine_db.prices WHERE magazine_db.prices.id_product = '.$product['id_product'].'');
                $stmt->execute();
                $prices[$product['id_product']] = $stmt->fetchAll();
            }*/
            //var_dump($prices);
            //die;
            
            /*foreach ($products  as $product) {
                $prepareProducts[$product['id_product']]['product'] = $product;
                if (!empty($prices[$product['id_product']])) {
                    $prepareProducts[$product['id_product']]['prices']['price'] = $prices[$product['id_product']]['price'];
                    //$prepareProducts[$product['id_product']]['prices']['id_status'] = $prices[$product['id_product']]['id_status'];
                    foreach ($prices as $price) {
                        $prepareProducts[$product['id_product']]['prices']['id_status'][] = $prices[$product['id_product']]['id_status'];
                    }
                } else {
                    $prepareProducts[$product['id_product']]['price'] = [];
                }
            }
            //var_dump($prepareProducts);*/
            return $prepareProducts;

            /*$products = $this->getAll();
            //var_dump($products);

            $product = $this->getOne('products', 3, 'id_product');
            //var_dump($product);*/
        }
    }
?>