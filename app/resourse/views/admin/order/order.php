<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<div>
    <h1>Orders</h1>
    <div>
        <table>
            <thead>
                <tr>
                    <th>ID Order</th>
                    <th>Status Name</th>
                    <th>Product Image</th>
                    <th>Count</th>
                    <th>Total Price</th>
                    <th>Customer</th>
                    <th>Seller</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allOrders as $order) { ?>
                    <tr>
                        <td><?= $order['id_order'] ?></td>
                        <td>
                            <select name="id_status">
                                <?php foreach ($allStatuses as $status) { ?>
                                    <option value="<?= $status['id_status'] ?>">
                                        <?= $status['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><?= $this->getImage(['name' => $order['product_image']]); ?> <?= $order['product_name'] ?></td>
                        <td><?= $order['total_quantity'] ?></td>
                        <td><?= $order['total_price'] ?></td>
                        <td>
                            <p>
                                <?= $order['customer_name'] ?> <?= $order['customer_second_name'] ?>
                            </p>
                            <p>
                                <?= $order['customer_phone'] ?>
                            </p> 
                            <p>
                                <?= $order['customer_email'] ?>
                            </p> 
                        </td>
                        <td><?= $order['user_name'] ?> <?= $order['user_second_name'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>