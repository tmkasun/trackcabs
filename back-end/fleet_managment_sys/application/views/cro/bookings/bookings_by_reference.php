<div class="panel panel-default">
<div class="panel-heading" style="padding: 1px">
    <h5 class="panel-title">Job Information</h5>
</div>
<div class="panel-body" >
    <div class="col-lg-12" style="padding-left: 1px; padding-right: 1px;" id="bookingStatus">
        <div class="panel panel-default col-lg-5" style="padding: 1px">

            <div class="panel-body" style="padding: 1px">
                <div class="col-lg-12">
                    <span class="col-lg-4" style="padding: 1px">Status</span>
                                <span class="col-lg-8" style="padding: 1px">
                                    <span id="jobStatus" class="label label-default"><?= $status;?></span>
                                </span>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-4" style="padding: 1px">Ref. ID</span>
                    <span class="col-lg-8" style="padding: 1px"><span class="badge" id="jobRefId"><?= $refId; ?></span></span>
                </div>


                <div class="col-lg-12">
                    <span class="col-lg-4" style="padding: 1px">V Type</span>
                    <span id="jobVehicleType" class="col-lg-8" style="padding: 1px"><?= $vType; ?></span>
                </div>


                <div class="col-lg-12">
                    <span class="col-lg-4" style="padding: 1px">Payment</span>
                    <span id="jobPayType" class="col-lg-8" style="padding: 1px"><?= $payType;?></span>
                </div>

                <div class="col-lg-12" style="padding: 1px">
                    <div class="well well-sm"><span class="col-lg-offset-3">Vehicle Details</span> </div>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-4" style="padding: 1px">Driver ID</span>
                    <span id="jobDriverId" class="col-lg-8" style="padding: 1px">
                        <?php if($driverId == '-' )echo 'NOT_ASSIGNED';else echo $driverId;?>
                    </span>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-4" style="padding: 1px">Cab ID</span>
                    <span id="jobCabId" class="col-lg-8" style="padding: 1px">
                        <?php if($cabId == '-' )echo 'NOT_ASSIGNED';else $cabId; ?>
                    </span>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-4" style="padding: 1px">Driver Tp</span>
                    <span id="jobDriverTp" class="col-lg-8" style="padding: 1px"><?= $driverTp;?></span>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-4" style="padding: 1px">[C]Color</span>
                    <span id="jobCabColor" class="col-lg-8" style="padding: 1px"><?= $cabColor;?></span>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-4" style="padding: 1px">Plate No</span>
                    <span id="jobCabPlateNo" class="col-lg-8" style="padding: 1px"><?= $cabPlateNo;?></span>
                </div>

            </div>
        </div>

        <div class="panel panel-default col-lg-7 " style="padding: 1px;">
            <div class="panel-body" style="padding: 1px">
                <span class="col-lg-3" style="padding: 1px">Address</span>
                    <span class="col-lg-9" style="padding: 1px">
                        <?= implode(", ", $address);?>
                    </span>

                <span class="col-lg-3" style="padding: 1px">Remark</span>
                <span id="jobRemark" class="col-lg-9" style="padding: 1px"><?= $remark?></span>

                <span class="col-lg-3" style="padding: 1px">Destination</span>
                <span id="jobDestination" class="col-lg-9" style="padding: 1px"><?= $destination?></span>

                <span class="col-lg-3" style="padding: 1px">Call Up</span>
                <span id="jobCallUpPrice" class="col-lg-9" style="padding: 1px"><?= $callUpPrice?> /=</span>

                <span class="col-lg-3" style="padding: 1px">Specs</span>
                    <span id="jobSpecifications" class="col-lg-9" style="padding: 1px">
                        <?php if($isVip)echo 'VIP | ';?>
                        <?php if($isVih)echo  'VIH | ';?>
                        <?php if($isUnmarked) echo 'UNMARK |'?>
                        <?php if($isTinted) echo 'Tinted'?> &nbsp;
                    </span>

                <span class="col-lg-3" style="padding: 1px">Paging[B]</span>
                <span id="jobPagingBoard" class="col-lg-9" style="padding: 1px"><?php echo $pagingBoard;?></span>

                <div class="col-lg-12" style="padding: 1px">
                    <div class="well well-sm"><span class="col-lg-offset-3">Time Details</span> </div>
                </div>

                <span class="col-lg-3" style="padding: 1px">Book Time</span>
                    <span id="jobBookTime" class="col-lg-9" style="padding: 1px">
                        <?php echo date('H:i Y-m-d ', $bookTime->sec);?>
                    </span>

                <span class="col-lg-3" style="padding: 1px">Call Time</span>
                    <span id="jobCallTime" class="col-lg-9" style="padding: 1px">
                        <?php echo date('H:i Y-m-d ', $callTime->sec);?>
                    </span>

                <span class="col-lg-3" style="padding: 1px">Dispatch</span>
                    <span id="jobDispatchB4" class="col-lg-9" style="padding: 1px">
                        <?= $dispatchB4;?> mins
                    </span>
            </div>
        </div>

        <div class="col-lg-12" style="margin-top: 5px ; padding: 1px">

            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default btn-sm" id="jobEditButton"
                            onclick="operations('editBooking', '<?= $live_booking[$index]['_id'];?>')">
                        <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Update
                    </button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default btn-sm" id="jobInquireButton"
                            onclick="operations('addInquireCall', '<?= $live_booking[$index]['_id'];?>')">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Inquire
                    </button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default btn-sm" id="jobComplaintButton"
                            onclick="operations('addComplaint', '<?= $live_booking[$index]['refId'];?>')">
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Complaint
                    </button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default btn-sm" id="jobCancelButton"
                            onclick="operations('cancel', '<?= $live_booking[$index]['_id'];?>')">
                        <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
