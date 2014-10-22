<?php
//var_dump($orders);
?>
<div class="panel panel-default boxElement" >
    <!-- Default panel contents -->
    <div class="panel-heading text-center"><span style="font-size: medium;" class="text-info" >New Orders</span></div>
    <!-- Table -->
    <table class="table table-hover">
<!--        <thead>-->
<!--        <tr>-->
<!--            <th>Phone number</th>-->
<!--            <th>Customer Name</th>-->
<!--            <th>Refference ID</th>-->
<!--            <th>Remarks</th>-->
<!--        </tr>-->
<!--        </thead>-->
        <tbody>
        <?php foreach($orders as $order){ ?>
        <tr style="cursor: pointer">
            <td><?= $order['tp'] ?></td>
            <td><?= date('Y-m-d H:i:s', $order['bookTime']->sec) ?></td>
            <td><?= $order['refId'] ?></td>
            <td><?= $order['remark'] ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>