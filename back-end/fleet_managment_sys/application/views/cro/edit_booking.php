<div class="col-lg-5">
    <form role="form" id="editBooking">
        <div class="form-group">
            <input type="text" class="form-control" id="no" value="<?= $refId?>" readonly >
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="no" value="<?= $address['no']?>" >
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="road" value="<?= $address['road']?>" >
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="city" value="<?= $address['city']?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="town" value="<?= $address['town']?>">
        </div>

        <div class="form-group">
            <input type="text" class="form-control" id="landMark" value="<?= $address['landmark']?>">
        </div>

        <div class="form-group">
            <input type="text" class="form-control" id="remark" value="<?= $remark?>">
        </div>

        <div class="form-group">
            <input type="text" class="form-control" id="dispatchB4" placeholder="Dispatch Before">
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" id="callUp" > Call Up
                </label>
            </div>
            <input type="text" class="form-control" id="callUpPrice" placeholder="Call Up Price" >
        </div>



    </form>
</div>


<div class="col-lg-3" style="border-left: 2px solid #a6a6a6" >

    <div class="form-group">
        <label for="dtp_input3" class="control-label">Booking Time</label>
        <div id="form_time" class="input-group date" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
            <input id="bTime" class="form-control" size="16" type="text" value="<?php echo date('H:i', $bookTime->sec);?>" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-time" onclick="showCalender()"></span></span>
        </div>
        <input type="hidden" id="dtp_input3" value="" /><br/>
    </div>

    <div class="form-group">
        <label for="dtp_input2" class="control-label">Booking Date</label>
        <div id="form_date" class="input-group date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
            <input id="bDate" class="form-control" size="16" type="text" value="<?php echo date('Y-m-d ', $bookTime->sec);?>" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="showCalender()"></span></span>
        </div>
        <input type="hidden" id="dtp_input2" value="" /><br/>
    </div>


    <h4>Classification</h4>
    <label class="checkbox-inline">
        <input type="checkbox" id="inlineCheckbox1" value="option1"> UN Mark
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" id="inlineCheckbox2" value="option2"> Tinted
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" id="inlineCheckbox3" value="option3"> VIP
    </label></br>
    <label>
        <input type="checkbox"  value="vih">
        VIH&mdash;Dr.Appointment, Court Case, Interview
    </label></br>

    <label>
        <input type="checkbox"  value="noNotSend">
        Don't Send Customer Mobile Number
    </label>



</div>

<div class="col-lg-2" style="border-left: 2px solid #a6a6a6">
    <div class="form-group">
        <h5>Choose Vehicle Type</h5>
        <label class="radio-inline">
            <input type="radio" id="carRadio" name="vehicleRadio" value="car"> Car
        </label>
        <label class="radio-inline">
            <input type="radio" id="vanRadio" name="vehicleRadio" value="van"> Van
        </label>
        <label class="radio-inline">
            <input type="radio" id="nanoRadio" name="vehicleRadio" value="nano"> Nano
        </label>
    </div>

    <div class="form-group">
        <h5>Payment Type</h5>
        <label class="radio-inline">
            <input type="radio" id="cashRadio" name="paymentRadio" value="cash"> Cash
        </label>
        <label class="radio-inline">
            <input type="radio" id="creditRadio" name="paymentRadio" value="credit"> Credit
        </label>
    </div>

</div>

<div class="col-lg-2">

    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <button type="button" class="btn btn-success" onclick="operations('updateBooking','<?= $_id?>')">Update Booking</button>
        </div>
    </div>
</div>






