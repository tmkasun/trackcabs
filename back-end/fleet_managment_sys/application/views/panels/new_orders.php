<?php
print($orders)
?>
<div class="panel panel-default boxElement" >
    <!-- Default panel contents -->
    <div class="panel-heading text-center"><span style="font-size: medium;" class="text-info" >New Orders</span></div>
    <!-- Table -->
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Phone number</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>+
        </tr>
        </thead>
        <tbody>
        <?php foreach($orders as $order): ?>
        <tr>
            <td><?= $order['tp'] ?></td>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>