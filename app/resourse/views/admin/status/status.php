<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<div>
    <h1>Statuses</h1>
    <form action="status/check" method="POST">
        <input type="text" name="name" value="<?= isset($name['name']) ? $name['name'] : '' ?>" class="input-width">
        <input type="text" name="category" value="<?= isset($category['category']) ? $category['category'] : '' ?>" class="input-width">
        <button type="submit" name="create">Create</button>
    </form>
    <table>
        <tr>
            <th>Id_Status</th>
            <th>Name</th>
            <th>Category</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php foreach ($allStatuses as $status) { ?>
            <form action="status/check" method="POST">
                <tr class="row">
                    <td><input type="text" name="id_status" value="<?= $status['id_status'] ?>" readonly></td>
                    <td><input type="text" name="name" value="<?= $status['name'] ?>" readonly></td>
                    <td><input type="text" name="category" value="<?= $status['category'] ?>" readonly></td>
                    <td>
                        <button type="submit" name="delete" value="<?= $status['id_status'] ?>">Delete</button>
                    </td>
                    <td>
                        <button type="button" class="update">Update</button>
                        <button type="submit" style="display: none" class="save" name="update">Save</button>
                    </td>
                </tr>
            </form>
        <?php } ?>
    </table>
</div>

<script src="/app/resourse/js/script.js"></script>