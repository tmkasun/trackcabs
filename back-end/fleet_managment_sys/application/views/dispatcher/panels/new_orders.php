<?php
//var_dump($orders);
?>
<!-- Custom JQuery scroll bars http://manos.malihu.gr/jquery-custom-content-scroller/ -->
<link rel="stylesheet" href="<?= base_url() ?>assets/css/custom_scroll/jquery.mCustomScrollbar.min.css">

<script src="<?= base_url() ?>assets/js/custom_scroll/jquery.mCustomScrollbar.min.js"></script>
<style>

    .mCSB_inside > .mCSB_container{
        margin-right: 15px;
    }
</style>
<script>
    //TODO: move this scripts to separate file like dispatcher.js in assets file currentDispatchOrderRefId
    function dispatchOrder(orderId){
        $("#commonModal").modal('toggle').find(".modal-content").load('dispatcher/newOrder/'+orderId);
        currentDispatchOrderRefId = orderId;
    }

    (function($){
        $(window).load(function(){
            $("#liveOrdersList").mCustomScrollbar({
                theme:"inset-dark"
            });
        });
    })(jQuery);

</script>

<div id="newOrdersPane" class="panel panel-default boxElement" style="height: 50%;">
    <div class="list-group">
        <a href="#" class="list-group-item active text-center">
            New Orders
        </a>
        <div id="liveOrdersList" style="overflow-y: auto;height: 90%;">
        <?php foreach($orders as $order){ ?>
                <a id="<?= $order['refId'] ?>" onclick="dispatchOrder(this.id);return false" class="list-group-item"><?= date('Y-m-d H:i:s', $order['bookTime']->sec) ?> <span class="label label-info" style="float: right"><?= $order['refId'] ?></span></a>
        <?php } ?>
        </div>
    </div>



</div>
<div id="dispatchedOrders" class="panel panel-default boxElement" style="height: 40%;">
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

        </tbody>
    </table>
</div>