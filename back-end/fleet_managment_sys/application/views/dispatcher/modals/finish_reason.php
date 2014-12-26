<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Manually finish order <?= $order['refId'] ?>
    </h4>
</div>

<div class="modal-body">
    <div class="row">
        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #d9534f;" type="button" class="btn btn-default"
                        onclick="cancelOrder(<?= $order['refId'] ?>)">Finish order
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