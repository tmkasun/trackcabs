<div class="col-lg-3" >
    <h6>Job Count</h6>
    <h5><?= $tot_job?></h5>

    <h6>Dispatched Cancellation</h6>
    <h5><?= $dis_cancel?></h5>

    <h6>Total Cancellation</h6>
    <h5><?= $tot_cancel?></h5>

</div>

<?php if(isset($history)) : ?>
    <div class="col-lg-3">
        <h6>Ref No</h6>
        <h5><?php echo $history[sizeof($history)-1]['refId']?></h5>

        <h6>Call Time</h6>
        <h5><?php echo date('Y-m-d H:i:s', $history[sizeof($history)-1]['callTime']->sec);?></h5>

        <h6>Book Time</h6>
        <h5><?php echo date('Y-m-d H:i:s', $history[sizeof($history)-1]['bookTime']->sec);?></h5>
    </div>

    <div class="col-lg-3">
        <h6>Status</h6>
        <h5>Start</h5>

        <h6></h6>
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <button type="button" class="btn btn-success" onclick="operations()">Edit Booking</button>
            </div>
        </div>
    </div>
<?php endif; ?>




