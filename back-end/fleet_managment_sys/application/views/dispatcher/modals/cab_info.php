<script>
</script>
<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title text-center">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Search Cab
    </h4>
</div>
<div class="modal-body">

    <div class="row">
        <div class="input-group input-group col-md-5 col-md-offset-4">
                <span class="input-group-addon" style="padding: 0px;margin: 0px;width: 180px;">
                <div id="cabSearchKey" data-toggle="buttons" class="btn-group btn-group-xs" role="group"
                     aria-label="Cab search">
                    <label class="btn btn-primary active">
                        <input type="radio" name="searchByCabId" value="cabId" autocomplete="off">ID
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="searchByCabModel" value="model" autocomplete="off">Model
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="searchByCabPlateNo" value="plateNo" autocomplete="off">Plate
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="searchByZone" value="zone" autocomplete="off">Zone
                    </label>

                    <!--                    <button id="searchByCabId" type="button" class="btn btn-default">ID</button>-->
                    <!--                    <button id="searchByCabModel" type="button" class="btn btn-default">Model</button>-->
                    <!--                    <button id="searchByCabPlateNo" type="button" class="btn btn-default">Driver</button>-->
                    <!--                    <button id="searchByZone" type="button" class="btn btn-default">zone</button>-->
                </div>
                </span>
            <input autofocus="true" id="cabSearch" type="text" class="form-control" placeholder="Search cabs"/>
                <span class="input-group-addon">
                <i id="resetSearch"
                   onclick="$('#searchCabsContainer').empty();/*$.each(unDispatchedOrders, function (i, order) {addNewOrder(order);});*/$('#cabSearch').val('');"
                   style="cursor: pointer;" class="fa fa-repeat"></i>
                </span>
        </div>
    </div>
    <div class="row" style="min-height: 100px">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Cab ID</th>
                <th>Plate No</th>
                <th>Model</th>
                <th>Color</th>
                <th>UserId</th>
                <th>Zone</th>
                <th>Info</th>
                <th>Calling Number</th>
                <th>Log Sheet Number</th>
            </tr>
            </thead>
            <tbody id="searchCabsContainer">
            <?php foreach ($assigned_cabs as $cab): ?>
                <tr>
                    <td>
                        <?= $cab['cabId'] ?>
                    </td>
                    <td>
                        <?= $cab['plateNo'] ?>
                    </td>
                    <td>
                        <?= $cab['model'] ?>
                    </td>
                    <td>
                        <?= $cab['color'] ?>
                    </td>
                    <td>
                        <?php if(!isset($cab['userId']) || $cab['userId'] == -1){echo "Not Assigned";}else{echo $cab['userId']; }  ?>
                    </td>
                    <td>
                        <?php if(!isset($cab['zone'])){echo "Not Available";} else{echo $cab['zone'];} ?>
                    </td>
                    <td>
                        <?= $cab['info'] ?>
                    </td>
<!--                    need to validate if key exists-->
                    <td contenteditable='true'>
                        <?= $cab['callingNumber'] ?>
                    </td>
                    <td contenteditable='true'>
                        <?= "Log Sheet Number" ?>
                    </td>                    
                </tr>
            <?php endforeach ?>


            </tbody>
        </table>
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

