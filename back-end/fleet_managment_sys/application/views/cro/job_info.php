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

    <?php if(isset($history)):?>
    <div class="col-lg-9" style="border-left: 2px solid #a6a6a6" >
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Last Booking Status</h3>
            </div>
            <div class="panel-body">

                <div class="col-lg-4">

                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="badge" id="jobStatus"><?= $live_booking[sizeof($live_booking)-1]['status']; ?></span>
                            Status
                        </li>
                        <li class="list-group-item">
                            <span class="badge" id="jobVehicleType"><?= $live_booking[sizeof($live_booking)-1]['vType']; ?></span>
                            Vehicle Type
                        </li>
                        <li class="list-group-item">
                            <span class="badge" id="jobDriverId"><?= $live_booking[sizeof($live_booking)-1]['driverId']; ?></span>
                            Driver ID
                        </li>
                        <li class="list-group-item">
                            <span class="badge" id="jobCabId"><?= $live_booking[sizeof($live_booking)-1]['cabId']; ?></span>
                            Cab ID
                        </li>
                    </ul>
                </div>

                <div class="col-lg-8">
                    <div class="col-lg-7">
                        <?php $index=sizeof($live_booking)-1;?>
                        <?php $status =$live_booking[sizeof($live_booking)-1]['status']; ?>

                        <h4>Address </h4>
                        <span id="jobAddress">
                            <?= $live_booking[sizeof($live_booking)-1]['address']['no'] ." ".
                                $live_booking[sizeof($live_booking)-1]['address']['road'] ." ".
                                $live_booking[sizeof($live_booking)-1]['address']['city'] ." ".
                                $live_booking[sizeof($live_booking)-1]['address']['town'];?>
                        </span>
                        <h4>Remark </h4>
                        <span id="jobRemark"><?= $live_booking[sizeof($live_booking)-1]['remark']?></span>
                        <h5>VIP | VIH | UNMARK | CASH</h5>
                    </div>

                    <div class="col-lg-5">

                        <h4>Book Time </h4>
                        <span id="jobBookTime"><?php echo date('H:i Y-m-d ', $live_booking[sizeof($live_booking)-1]['bookTime']->sec);?></span>
                        </br>
                        <h4>Call Time </h4>
                        <span id="jobCallTime"><?php echo date('H:i Y-m-d ', $live_booking[sizeof($live_booking)-1]['callTime']->sec);?></span>
                        </br>
                        <h4>Dispatch Before </h4>
                        <span id="jobDispatchB4">30min

                    </div>
                </div>

                <div class="col-lg-offset-8 col-lg-4">
                    <div class="btn-group btn-group-justified">
                        <?php if( ($status == "START") || ($status == 'MSG_COPIED') || ($status =='MSG_NOT_COPIED') || ($status =='AT_THE_PLACE')):?>

                            <div class="btn-group">
                                <button type="button" class="btn btn-warning" onclick="operations('editBooking', '<?= $live_booking[sizeof($live_booking)-1]['_id'];?>')">Edit Booking</button>
                            </div>

                        <?php endif; ?>
                        <?php if( ($status == "START") || ($status == 'MSG_COPIED') || ($status =='MSG_NOT_COPIED') || ($status =='AT_THE_PLACE')):?>

                            <div class="btn-group">
                                <button type="button" class="btn btn-danger" onclick="operations('cancel' , '<?php echo $live_booking[sizeof($live_booking)-1]['_id']?>' )">Cancel</button>
                            </div>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
</div>


<div class="col-lg-12">
    <?php if(isset($history)):?>
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
                <td><a href="#" onclick="changeJobInfoView('<?= $_id?>')"><?= $item['status'];?></td>
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