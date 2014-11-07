<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">New Order</h3>
    </div>
    <div class="panel-body" >
        <form id="editBookingForm">
            <div class="col-lg-5">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Location Details</h3>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">Number</label>
                            <input class="form-control" type="text" value="<?= $address['no']?>"  id="no"      name="no"      placeholder="Number" >
                        </div>
                        <div class="form-group">
                            <label>Road</label>
                            <input type="text" class="form-control" value="<?= $address['road']?>" id="road"     name="road"     placeholder="Road" >
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" value="<?= $address['city']?>" id="city"     name="city"     placeholder="City">
                        </div>
                        <div class="form-group">
                            <label>Town</label>
                            <input type="text" class="form-control" value="<?= $address['town']?>" id="town"     name="town"     placeholder="Town">
                        </div>
                        <div class="form-group">
                            <label>Land Mark</label>
                            <input type="text" class="form-control" value="<?= $address['landmark']?>" id="landMark" name="landMark" placeholder="Land Mark">
                        </div>
                    </div>

                </div>

                <div class="panel panel-success" style="margin-top:2%">
                    <div class="panel-heading">
                        <h3 class="panel-title">Other Dispatch Details</h3>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label>Remark</label>
                            <input type="text" class="form-control" value="<?= $remark?>" id="remark"       name="remark"    placeholder="Remark">
                        </div>
                        <div class="form-group">
                            <label>Dispatch Before<small style="font-weight: lighter"> [In Minutes]</small></label>
                            <input type="text" class="form-control" id="dispatchB4"   name="dispatchBefore"   value="<?= $dispatchB4;?>" placeholder="Dispatch Before">
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label style="font-weight: bold">
                                    <input type="checkbox" name="callUp"  id="callUp" class="checkBoxMakeAppear"> Call Up Given
                                </label>
                                <input type="text" class="form-control checkBoxElementAppearing" id="callUpPrice" value="<?= $callUpPrice?>" name="callUpPrice" placeholder="Call Up Price" style="display:none">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label style="font-weight: bold"><input type="checkbox" name="destinationGiven"  id="destinationGiven" class="checkBoxMakeAppear"> Destination
                                </label>
                                <input type="text" class="form-control checkBoxElementAppearing" id="destination" value="<?= $destination?>" name="destination" placeholder="Given Destination" style="display:none">
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-lg-5" style="border-left: 2px solid #eee" >
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Booking Details</h3>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label class="control-label" style="font-weight:bold">Vehicle Type</label></br>
                            <div class="btn-group">
                                <button type="button" id="carRadio"  data-set="vehicle" value="car" class="btn btn-default customRadio <?php if($vType == 'car')echo 'active';?>" >Car</button>
                                <button type="button" id="vanRadio"  data-set="vehicle" value="van" class="btn btn-default customRadio <?php if($vType == 'van')echo 'active';?>" >Van</button>
                                <button type="button" id="nanoRadio"   data-set="vehicle" value="nano" class="btn btn-default customRadio <?php if($vType == 'nano')echo 'active';?>" >Nano</button>
                            </div>
                            <input style="display: none" class="customRadio" name="vehicleType" id="vehicleType">

                        </div>

                        <div class="form-group">
                            <label class="control-label" style="font-weight:bold">Payment Type</label></br>
                            <div class="btn-group">
                                <button type="button" data-set="payment" value="cash " class="btn btn-default customRadio <?php if($payType == 'cash')echo 'active';?>" >Cash</button>
                                <button type="button" data-set="payment" value="credit" class="btn btn-default customRadio <?php if($payType  == 'credit')echo 'active';?>" >Credit Card</button>
                            </div>
                            <input style="display: none" class="customRadio" name="paymentType" id="paymentType">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Booking Time</label>
                            <div id="form_time" class="input-group date" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
                                <input id="bTime" name="bTime" class="form-control" name= size="16" type="text" value="<?php echo date('H:i', $bookTime->sec);?>" readonly="readonly">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-time" onclick="showCalender()"></span></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Booking Date</label>
                            <div id="form_date" class="input-group date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                <input id="bDate" name="bDate" class="form-control" size="16" type="text" value="<?php echo date('Y-m-d ', $bookTime->sec);?>" readonly="readonly">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="showCalender()"></span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success" style="margin-top:2%">
                    <div class="panel-heading">
                        <h3 class="panel-title">Booking Requirements</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="unmarked" <?php if($isUnmarked === true)echo 'checked';?> >Unmarked</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="tinted"   <?php if($isTinted === true)echo 'checked';?>    >Tinted</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="vip"  <?php if($isVip === true)echo 'checked';?>         >VIP</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="vih"  <?php if($isVih === true)echo 'checked';?>    >Very Important Hire<small style="font-weight: lighter"> [Court Case/Interview/Appointment]</small></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="cusNumberNotSent" <?php if($isCusNumberNotSent === true)echo 'checked';?>>Don't Send Customer Number</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group" style="text-align: center">
                    <button type="button" style="width:100%" class="btn btn-success" onclick="operations('updateBooking','<?= $_id?>');return false">Update Booking</button>
                </div>
            </div>
        </form>

    </div>
</div>






