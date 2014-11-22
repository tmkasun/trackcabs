<div class="col-lg-5" >
    <h4>Confirm Cancel For Reference ID <?= $refId?></h4>

    <form role="form">

        <div class="form-group">
            <label class="radio-inline">
                <input type="radio" id="cancel1Radio" name="cancelReason" value="1"> Appointment Cancelled
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel2Radio" name="cancelReason" value="2"> Cancelled By Customer
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel3Radio" name="cancelReason" value="3"> Got a Lift
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel4Radio" name="cancelReason" value="4"> Delayed By Base
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel4Radio" name="cancelReason" value="5"> No Response
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel4Radio" name="cancelReason" value="6"> Unavoidable Circumstances
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel4Radio" name="cancelReason" value="7"> Duplicate Booking
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel4Radio" name="cancelReason" value="8"> Picked By another company car
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel4Radio" name="cancelReason" value="9"> No vehicles at location
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