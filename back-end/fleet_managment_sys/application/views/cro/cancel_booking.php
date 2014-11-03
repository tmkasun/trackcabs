<div class="col-lg-5" >
    <h4>Confirm Cancel For Reference ID <?php echo $refId; ?></h4>


    <form role="form">

        <div class="form-group">
            <label class="radio-inline">
                <input type="radio" id="cancel1Radio" name="cancelReason" value="1"> Traffic Filled , Driver late
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel2Radio" name="cancelReason" value="2"> Customer Cancelled
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel3Radio" name="cancelReason" value="3"> Some Reason
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel4Radio" name="cancelReason" value="4"> Some Reason 2
            </label> </br>
        </div>

    </form>
</div>

<div class="col-lg-3">
    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <button type="button" class="btn btn-danger" onclick="operations('confirmCancel', '<?php echo $_id; ?>')">Confirm Cancel</button>
        </div>
    </div>
    <div class="btn-group btn-group-justified" style="margin-top: 10%">
        <div class="btn-group">
            <button type="button" class="btn btn-success" onclick="operations('denyCancel')">Deny Cancel</button>
        </div>
    </div>
</div>