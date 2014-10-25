<div class="col-lg-3" >
    <h6>Job Count</h6>
    <h5><?= $tot_job?></h5>

    <h6>Dispatched Cancellation</h6>
    <h5><?= $dis_cancel?></h5>

    <h6>Total Cancellation</h6>
    <h5><?= $tot_cancel?></h5>

</div>

<?php if( sizeof($booking) != 0) : ?>
<?php $status =$booking[sizeof($booking)-1]['status']; ?>
    <div class="col-lg-3">
        <h6>Ref No</h6>
        <h5><?php echo $booking[sizeof($booking)-1]['refId']?></h5>

        <h6>Call Time</h6>
        <h5><?php echo date('H:i:s Y-m-d', $booking[sizeof($booking)-1]['callTime']->sec);?></h5>

        <h6>Book Time</h6>
        <h5><?php echo date('H:i:s Y-m-d ', $booking[sizeof($booking)-1]['bookTime']->sec);?></h5>

        <?php if( ($status == "START") || ($status == 'MSG_COPIED') || ($status =='MSG_NOT_COPIED') || ($status =='AT_THE_PLACE')):?>
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <button type="button" class="btn btn-success" onclick="operations('editBooking', '<?= $booking[sizeof($booking)-1]['_id'];?>')">Edit Booking</button>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <div class="col-lg-3">
        <h6>Status</h6>
        <h5><?php echo $booking[sizeof($booking)-1]['status']?></h5>

        <h6>Cab Id</h6>
        <h5><?php echo $booking[sizeof($booking)-1]['cabId']?></h5>

        <h6>Driver Id</h6>
        <h5><?php echo $booking[sizeof($booking)-1]['driverId']?></h5>

    <?php if( ($status == "START") || ($status == 'MSG_COPIED') || ($status =='MSG_NOT_COPIED') || ($status =='AT_THE_PLACE')):?>
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <button type="button" class="btn btn-danger" onclick="operations('cancel' , '<?php echo $booking[sizeof($booking)-1]['_id']?>' )">Cancel</button>
            </div>
        </div>
    <?php endif; ?>

    </div>

<div class="col-lg-3">
    <div class="col-lg-12">
        <table class="table table-striped" >
            <tr>
                <th>Order ID</th>
                <th>Status</th>
            </tr>

            <tr>
                <td>12</td>
                <td>START</td>
            </tr>
        </table>
    </div>
    <div class="col-lg-offset-10 col-lg-2" >
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <button type="button" class="btn btn-success" onclick="operations('editCus' )">Edit Information</button>
            </div>
        </div>
<?php endif; ?>





