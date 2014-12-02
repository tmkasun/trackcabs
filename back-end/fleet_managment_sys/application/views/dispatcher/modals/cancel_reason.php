<script>

    function cancelOrder(orderRefId) {
        var cancelReason =$('input[name=cancelReason]:checked').val();
        console.log("DEBUG:");
        console.log(cancelReason);

//        var confirmation = confirm("Are you sure you want to cancel this order!");
//        if (!confirmation) {
//            return false;
//        }

        closeAll();
        $("#orderBuilder").html('');
        $.post('dispatcher/cancelOrder', {refId: orderRefId,'cancelReason' : cancelReason}).done(
            function () {
                $("#orderBuilder").html('');
                closeAll();
                var orderDOM = $('#liveOrdersList').find('#' + orderRefId);
                $(orderDOM).fadeOut();
                $('#liveOrdersList').find('#' + orderRefId).remove();
                $('#dispatchedOrdersList').find('#' + orderRefId).remove();
                delete unDispatchedOrders[orderRefId];
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

</script>

<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Confirm Cancel For Reference ID <?= $order['refId'] ?>
    </h4>
</div>


<div class="modal-body">


    <div class="col-md-5">
        <form role="form">

            <div class="form-group">
                <label class="radio-inline">
                    <input type="radio" id="cancel1Radio" name="cancelReason" value="Appointment Cancelled"> Appointment
                    Cancelled
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel2Radio" name="cancelReason" value="Cancelled By Customer"> Cancelled
                    By Customer
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel3Radio" name="cancelReason" value="Got a Lift"> Got a Lift
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel4Radio" name="cancelReason" value="Delayed By Base"> Delayed By Base
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel4Radio" name="cancelReason" value="No Response"> No Response
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel4Radio" name="cancelReason" value="Unavoidable Circumstances">
                    Unavoidable Circumstances
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel4Radio" name="cancelReason" value="Duplicate Booking"> Duplicate
                    Booking
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel4Radio" name="cancelReason" value="Picked By another company car">
                    Picked By another company car
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel4Radio" name="cancelReason" value="No vehicles at location"> No
                    vehicles at location
                </label> </br>
            </div>
        </form>
    </div>

    <div class="row">
        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #d9534f;" type="button" class="btn btn-default"
                        onclick="cancelOrder(<?= $order['refId'] ?>)">Confirm cancellation
                </button>
            </div>

            <div class="btn-group">
                <button style="background-color: #f0e6e8;" type="button" class="btn btn-default" onclick="closeAll()">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>