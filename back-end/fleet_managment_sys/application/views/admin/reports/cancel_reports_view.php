<table class="table table-striped" >
    <tr>
    <button type="submit" class="btn btn-default" id="CANCEL" onclick="getCancelReportsView('CANCEL')">CANCEL-REPORTS</button>
    <button type="submit" class="btn btn-default" id="DIS_CANCEL" onclick="getCancelReportsView('DIS_CANCEL')">DIS-CANCEL-REPORTS</button>
    <button type="submit" class="btn btn-default" id="ALL" onclick="getCancelReportsView('ALL')">ALL</button>
    
    </tr>
    <tr>        
        <th>Booking Ref ID</th>
        <th>Type</th>
        <th>Reason</th>
        <th>Time Vehicle REQ</th>
        <th>Time Vehicle Dispatched</th>
        <th>Time of Cancellation</th>
        <th>Time Diff (REQ/Cancel)</th>
        <th>Time Diff (DISP/Cancel)</th>
        <th>CRO ID (Made Booking)</th>
        <th>USR ID (Made Cancel)</th>
        <th>Driver ID</th>

    </tr>

    <?php foreach ($cancellations as $item):?>

    <tr>
        <td><?= $item['refId']?></td>
        <td><?= $item['status']?></td>
        <td><?php if(isset($item['cancelReason'])){echo $item['cancelReason'];}else{echo "Not Available";}?></td>
        <td><?= date('H:m Y-m-d',$item['bookTime']->sec)?></td>
        <td><?php if(isset($item['time_of_dispatch'])){echo date('H:m Y-m-d',$item['time_of_dispatch']->sec);}else{echo "Not Available";}?></td>
        <td><?php if(isset($item['cancelTime'])){echo date('H:m Y-m-d',$item['cancelTime']->sec);}else{echo "Not Available";}?></td>
        <td><?php if(isset($item['time_of_cancellation'])){echo "diff";}else{echo "Not Available";}?></td>
        <td><?php if(isset($item['time_of_cancellation'])){echo "diff";}else{echo "Not Available";}?></td>
        <td><?= $item['croId']?></td>
        <td><?php if(isset($item['cancelUserId'])){echo $item['cancelUserId'];}else{echo "Not Available";}?></td>
        <td><?php if(isset($item['driverId'])){echo $item['driverId'];}else{echo "Not Available";}?></td>
    </tr>

    <?php endforeach;?>
</table>
