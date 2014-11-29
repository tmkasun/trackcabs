<script>
</script>
<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Search Cab
    </h4>
</div>
<div class="modal-body">

    <div class="row">
        <div class="input-group input-group">
                <span class="input-group-addon" style="padding: 0px;margin: 0px;width: 120px;">
                <div class="btn-group btn-group-xs" role="group" aria-label="Extra-small button group">
                    <button id="searchByCabId" type="button" class="btn btn-default active">ID</button>
                    <button id="searchByCabModel" type="button" class="btn btn-default">Model</button>
                    <button id="searchByCabDriver" type="button" class="btn btn-default">Driver</button>
                    <!--                    <button id="searchByCabId" type="button" class="btn btn-default">Cab#</button>-->
                </div>
                </span>
            <input autofocus="true" id="cabSearch" type="text" class="form-control" placeholder="Search cabs"/>
                <span class="input-group-addon">
                <i id="resetSearch"
                   onclick="$('#searchCabsContainer').empty();$.each(unDispatchedOrders, function (i, order) {addNewOrder(order);});$('#orderSearch').val('');"
                   style="cursor: pointer;" class="fa fa-repeat"></i>
                </span>
        </div>
    </div>
    <div id="searchCabsContainer" class="row" style="min-height: 100px">
    </div>
    <div class="row">
        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #f0ad4e;" type="button" class="btn btn-default" onclick="closeAll()">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>