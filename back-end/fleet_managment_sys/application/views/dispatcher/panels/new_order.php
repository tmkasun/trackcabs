<script>
    //TODO: move this scripts to separate file like dispatcher.js in assets file
    function allowDispatchCab(refId) {
        closeAll();
//        $("#newOrdersPane").fadeOut('slow');
        $.UIkit.notify({
            message: "Order: " + refId + " selected for dispatch!",
            status: 'success',
            timeout: 0,
            pos: 'top-center'
        });
        currentDispatchOrderRefId = refId;
    }

    function cancelOrder(orderRefId) {
        var confirmation = confirm("Are you sure you want to cancel this order!");
        if (!confirmation) {
            $.UIkit.notify({
                message: "Order not cancelled.",
                status: 'success',
                timeout: 3000,
                pos: 'top-center'
            });
            return false;
        }
        $.post('dispatcher/cancelOrder', {refId: orderRefId}).done(
            function () {
                var orderDOM = $('#liveOrdersList').find('#' + orderRefId);
                $(orderDOM).fadeOut();
                orderDOM.appendTo('#dispatchedOrdersList .mCSB_container');
                $('#liveOrdersList').find('#' + orderRefId).remove();
                setTimeout(function () {
                    orderDOM.show()
                }, 500);
                $.UIkit.notify({
                    message: "Order: <b>" + orderRefId + "</b> has been canceled!",
                    status: 'success',
                    timeout: 3000,
                    pos: 'top-center'
                });
            }
        ).
            fail(
            function () {
                $.UIkit.notify({
                    message: "Can't cancel Order: <b>" + orderRefId + "</b> Something went wrong!",
                    status: 'danger',
                    timeout: 3000,
                    pos: 'top-center'
                });
            }
        );

    }

    function delayInform(refId) {
//        console.log("refId = "+refId);
        closeAll();
        var minutes = $('#delayInforMinutes').val();
        $.post('dispatcher/delayInform', {refId: refId, minutes: minutes}, function (response) {
            $.UIkit.notify({
                message: "Delay informed to all CROs",
                status: 'success',
                timeout: 3000,
                pos: 'top-center'
            });
        });
    }
</script>
<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Booking #<i><?= $newOrder['refId'] ?></i>
    </h4>
</div>
<div class="modal-body">

    <p class="text-info text-center">Booking details</p>

    <div class="row">
        <div class="col-md-6 well well-sm">
            <?php foreach ($newOrder['address'] as $key => $addressComponents) : ?>
                <div class="input-group input-group-sm" style="margin-bottom: 5px;">
                    <span style="width: 30%" class="input-group-addon"><?= $key ?></span>
                    <input class="form-control text-center" disabled type="text" value="<?= $addressComponents ?>"/>
                </div>
            <?php endforeach ?>

        </div>
        <div class="col-md-6">

            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Customer: <?= $customerProfile['title'] . ". " . $customerProfile['name'] ?> </h3>
                </div>
                <div class="panel-body">
                    <span class="col-md-6">Job Count  :</span>
                    <span class="col-md-6 text-primary"><?= $customerProfile['tot_job'] ?></span>


                    <span class="col-md-6">Cancel [T]  :</span>
                    <span class="col-md-6 text-danger"><?= $customerProfile['tot_cancel'] ?></span>

                    <span class="col-md-6">Cancel [D]  :</span>
                    <span class="col-md-6 text-danger"><?= $customerProfile['dis_cancel'] ?></span>

                    <!--                        <img class="img-responsive center-block" src="-->
                    <? //= base_url() ?><!--assets/img/cabs/--><? //= $newOrder['vType'] ?><!--.png" alt="-->
                    <? //= $newOrder['vType'] ?><!--">-->


                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item">
                    <?= getBadge($newOrder['isVip']) ?>
                    VIP
                </li>

                <li class="list-group-item">
                    <?= getBadge($newOrder['isVih']) ?>
                    VIH
                </li>

                <li class="list-group-item">
                    <?= getBadge($newOrder['isTinted']) ?>
                    Tinted
                </li>

                <li class="list-group-item">
                    <?= getBadge($newOrder['isUnmarked']) ?>
                    Unmarked
                </li>
            </ul>
        </div>
        <div class="col-md-6">

            <div class="input-group input-group-sm">
                <span class="input-group-addon">Remarks:</span>
                <input class="form-control" disabled type="text"
                       value="<?= $newOrder['remark'] ?>"/>
            </div>
            <br>

            <div class="input-group input-group-sm">
                <span class="input-group-addon">Dispatch before:</span>
                <input style="text-align: right" class="form-control" disabled type="text"
                       value="<?= $newOrder['dispatchB4'] ?>"/>
                <span class="input-group-addon">Min</span>
            </div>
            <br>

            <div class="input-group input-group-sm">
                <span class="input-group-addon">Order status:</span>
                <input class="form-control" disabled type="text"
                       value="<?= $newOrder['status'] ?>"/>
            </div>
            <br>

            <div class="input-group input-group-sm">
                <span class="input-group-addon">CRO ID:</span>
                <input class="form-control" disabled type="text"
                       value="<?= $newOrder['croId'] ?>"/>
            </div>
            <br>

            <div class="input-group input-group-sm">
                <span class="input-group-addon">Type:</span>
                <input class="form-control" disabled type="text"
                       value="<?= $newOrder['vType'] ?>"/>
            </div>
            <br>

            <div class="input-group input-group-sm">
                <span class="input-group-addon" style="padding: 0px;margin: 0px;width: 90px;">
                    <button class="btn btn-warning btn-xs" type="button"
                            onclick="delayInform(<?= $newOrder['refId'] ?>)">Delay inform
                    </button>
                </span>
                <input id="delayInforMinutes" autocomplete="off" type="text" class="form-control"
                       style="text-align: right" placeholder="Request minutes"/>
                <span class="input-group-addon">min</span>
            </div>
        </div>

        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #f4f4f4;" type="button" class="btn btn-default"
                        onclick="allowDispatchCab(<?= $newOrder['refId'] ?>)">Assign cab
                </button>
            </div>
            <div class="btn-group">
                <button style="background-color: #d9534f;color: #ffffaa" type="button" class="btn  btn-default"
                        onclick="cancelOrder(<?= $newOrder['refId'] ?>);">Cancel order
                </button>
            </div>
            <!--<div class="btn-group">-->
            <!--<button style="background-color: #f4f4f4;" type="button" class="btn  btn-default" onclick="closeAll()">Cancel</button>-->
            <!--</div>-->
        </div>
    </div>
</div>
<?php
function getBadge($status)
{
    $status = (bool)$status;
    if ($status) {
        $returnBadge = '<span class="badge alert-info"><span style="color: #5cb85c" class="glyphicon glyphicon-ok"></span></span>';
    } else {
        $returnBadge = '<span class="badge alert-warning"><span style="color: #d9534f" class="glyphicon glyphicon-remove"></span></span>';
    }
    return $returnBadge;
}

?>