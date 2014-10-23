<script>
    //TODO: move this scripts to separate file like dispatcher.js in assets file
    function allowDispatchCab(refId){
        closeAll();
        $("#newOrdersPane").fadeOut('slow');
        $.UIkit.notify({
            message: "Select a vehicle to dispatch....",
            status: 'success',
            timeout: 0,
            pos: 'top-center'
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
    <div class="row">
        <p class="text-info text-center">Booking details</p>

        <div class="">
            <div class="input-group input-group-sm">
                <span class="input-group-addon">Address:</span>
                <input class="form-control" disabled autofocus="enable" id="serviceName" type="text" value="<?= implode(", ",$newOrder['address']) ?>" />
            </div>
            <br>

            <div class="input-group input-group-sm">
                <span class="input-group-addon">Vehicle Type:</span>
                <input class="form-control" disabled autofocus="enable" id="serviceName" type="text" value="<?= $newOrder['vType'] ?>" />
            </div>
            <br>

            <div class="input-group input-group-sm">
                <span class="input-group-addon">Order status:</span>
                <input class="form-control" disabled autofocus="enable" id="serviceName" type="text" value="<?= $newOrder['status'] ?>" />
            </div>
            <br>

            <div class="input-group input-group-sm">
                <span class="input-group-addon">Remarks:</span>
                <input class="form-control" disabled autofocus="enable" id="serviceName" type="text" value="<?= $newOrder['remark'] ?>" />
            </div>
            <br>

            <div class="input-group input-group-sm">
                <span class="input-group-addon">Book time:</span>
                <input class="form-control" disabled autofocus="enable" id="serviceName" type="text" value="<?= date('Y-m-d H:i:s', $newOrder['bookTime']->sec) ?>" />
            </div>
            <br>

        </div>
        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #f4f4f4;" type="button" class="btn btn-default"
                        onclick="allowDispatchCab(<?= $newOrder['refId'] ?>)">Dispatch cab
                </button>
            </div>
            <div class="btn-group">
                <button style="background-color: #f4f4f4;" type="button" class="btn  btn-default"
                        onclick="$('#editWithinGeoJSON').modal('toggle')">Cancel
                </button>
            </div>
            <!--<div class="btn-group">-->
            <!--<button style="background-color: #f4f4f4;" type="button" class="btn  btn-default" onclick="closeAll()">Cancel</button>-->
            <!--</div>-->
        </div>
    </div>
</div>