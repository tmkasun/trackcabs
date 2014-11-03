<div class="col-lg-12">
    <div class="col-lg-3"   >
        <ul class="list-group">
            <li class="list-group-item">
                <span class="badge" id="jobCount"><?= $tot_job?></span>
                Job Count
            </li>
            <li class="list-group-item">
                <span class="badge"><?= $tot_cancel?></span>
                Cancel[Total]
            </li>
            <li class="list-group-item">
                <span class="badge"><?= $dis_cancel?></span>
                Cancel[Dispatch]
            </li>
        </ul>
    </div>

    <?php if(isset($live_booking) ):?>
    <div class="col-lg-9" style="border-left: 2px solid #a6a6a6" >
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Booking Status</h3>
            </div>
            <div class="panel-body" id="bookingStatus">
                <?php $index=sizeof($live_booking)-1;?>
                <div class="col-lg-4">

                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="badge" id="jobStatus"><?= $live_booking[$index]['status']; ?></span>
                            Status
                        </li>
                        <li class="list-group-item">
                            <span class="badge" id="jobStatus"><?= $live_booking[$index]['refId']; ?></span>
                            Reference ID
                        </li>
                        <li class="list-group-item">
                            <span class="badge" id="jobDriverId"><?php if($live_booking[$index]['driverId'] == '-' )echo 'NOT_ASSIGNED'; ?></span>
                            Driver ID
                        </li>
                        <li class="list-group-item">
                            <span class="badge" id="jobCabId"><?php if($live_booking[$index]['cabId'] == '-' )echo 'NOT_ASSIGNED'; ?></span>
                            Cab ID
                        </li>
                        <li class="list-group-item">
                            <span class="badge" id="jobVehicleType"><?= $live_booking[sizeof($live_booking)-1]['vType']; ?></span>
                            Vehicle Type
                        </li>
                    </ul>
                </div>

                <div class="col-lg-8">
                    <div class="col-lg-7">
                        <?php $status =$live_booking[$index]['status']; ?>

                        <h4>Address </h4>
                        <span id="jobAddress">
                            <?= $live_booking[$index]['address']['no'] ." ".
                                $live_booking[$index]['address']['road'] ." ".
                                $live_booking[$index]['address']['city'] ." ".
                                $live_booking[$index]['address']['town'];?>
                        </span>
                        <h4>Remark </h4>
                        <span id="jobRemark"><?= $live_booking[$index]['remark']?></span>
                        <h4>Specifications</h4>
                            <span id="jobSpecifications"> <?php if($live_booking[$index]['isVip'])echo 'VIP | ';?>
                                                          <?php if($live_booking[$index]['isVih'])echo  'VIH | ';?>
                                                          <?php if($live_booking[$index]['isUnmarked']) echo 'UNMARK |'?>
                                                          <?php if($live_booking[$index]['isTinted']) echo 'Tinted'?>
                            </span>
                    </div>

                    <div class="col-lg-5">

                        <h4>Book Time </h4>
                        <span id="jobBookTime"><?php echo date('H:i Y-m-d ', $live_booking[$index]['bookTime']->sec);?></span>
                        </br>
                        <h4>Call Time </h4>
                        <span id="jobCallTime"><?php echo date('H:i Y-m-d ', $live_booking[$index]['callTime']->sec);?></span>
                        </br>
                        <h4>Dispatch Before </h4>
                        <span id="jobDispatchB4"><?= $live_booking[$index]['dispatchB4'];?> min

                    </div>
                </div>

                <div class="col-lg-offset-8 col-lg-4">
                        <div id="jobEditButton" class="col-lg-6">
                            <?php if( ($status == "START") || ($status == 'MSG_COPIED') || ($status =='MSG_NOT_COPIED') || ($status =='AT_THE_PLACE')):?>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning" onclick="operations('editBooking', '<?= $live_booking[$index]['_id'];?>')">Edit Booking</button>
                                </div>

                            <?php endif?>
                        </div>
                        <div id="jobCancelButton" class="col-lg-6">
                            <?php if( ($status == "START") || ($status == 'MSG_COPIED') || ($status =='MSG_NOT_COPIED') || ($status =='AT_THE_PLACE')):?>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger" onclick="operations('cancel' , '<?php echo $live_booking[$index]['_id']?>' )">Cancel</button>
                                </div>

                            <?php endif?>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
</div>


<div class="col-lg-12">
    <?php if(isset($live_booking)):?>
    <table class="table table-striped" style="max-height: 50px;overflow: scroll;margin-top: 3%;">
        <tr>
            <th>Status</th>
            <th>Ref ID</th>
            <th>Call Time</th>
            <th>Book Time</th>
            <th>Address</th>
            <th>Driver Id</th>
            <th>Cab Id</th>
            <th>Remark</th>
        </tr>
        <?php foreach(array_reverse($live_booking) as $item):?>
            <tr>
                <td><a href="#" onclick="changeJobInfoView('<?= $item['_id']?>')"><?= $item['status'];?></td>
                <td><?= $item['refId'];?></td>
                <td><?=  date('H:i:s Y-m-d ', $item['callTime']->sec);?></td>
                <td><?=  date('H:i:s Y-m-d ', $item['bookTime']->sec);?></td>
                <td><?= $item['address']['no'] ." ". $item['address']['road'] ." ". $item['address']['city'] ." ". $item['address']['town'];?></td>
                <td><?= $item['driverId'];?></td>
                <td><?= $item['cabId'];?></td>
                <td><?= $item['remark'];?></td>
            </tr>

        <?php endforeach?>
    </table>
    <?php endif;?>
</div>