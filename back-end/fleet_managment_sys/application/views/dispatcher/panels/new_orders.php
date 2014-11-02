<?php
//var_dump($orders);
?>
<script>
    //TODO: move this scripts to separate file like dispatcher.js in assets file currentDispatchOrderRefId
    function dispatchOrder(orderId){
        $("#commonModal").modal('toggle').find(".modal-content").load('dispatcher/newOrder/'+orderId);
        currentDispatchOrderRefId = orderId;
    }
</script>
<div class="panel panel-default boxElement" style="height: 90%;">
    <!-- Default panel contents -->
    <div class="panel-heading text-center"><span style="font-size: medium;" class="text-info" >New Orders</span></div>
    <!-- Table -->
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Ref Id</th>
            <th># number</th>
            <th>Booking</th>
            <th>Remarks</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($orders as $order){ ?>
<!--            TODO: date time compare and color the row , sorting dispatching -->
        <tr id="<?= $order['refId'] ?>" style="cursor: pointer" onclick="dispatchOrder(this.id)">
            <td><?= $order['refId'] ?></td>
            <td><?= $order['tp'] ?></td>
            <td><?= date('Y-m-d H:i:s', $order['bookTime']->sec) ?></td>
            <td><?= $order['remark'] ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>