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
        <th>Time Booking Made</th>
        <th>Time Vehicle Dispatched</th>
        <th>Time of Cancellation</th>
        <th>Interval</th>
        <th>CRO ID (Made Booking)</th>
        <th>CRO ID (Took Complaint)</th>
        <th>Driver ID</th>
        
        

    </tr>


    <?php foreach ($cancellations as $item):?>

    <tr>
        <td><?= $item['refId']?></td>
        <td><?= $item['status']?></td>
        <td><?php if(isset($item['reason'])){echo $item['reason'];}else{echo "Not Available";}?></td>
        <td><?= date('H:m Y-m-d',$item['bookTime']->sec)?></td>
        <td><?php if(isset($item['time_of_dispatch'])){echo date('H:m Y-m-d',$item['time_of_dispatch']->sec);}else{echo "Not Available";}?></td>
        <td><?php if(isset($item['time_of_cancellation'])){echo date('H:m Y-m-d',$item['time_of_cancellation']->sec);}else{echo "Not Available";}?></td>
        <td><?php if(isset($item['time_of_cancellation'])){echo "diff";}else{echo "Not Available";}?></td>
        <td><?= $item['croId']?></td>
        <td><?php if(isset($item['userId_cro_complaint'])){echo $item['userId_cro_complaint'];}else{echo "Not Available";}?></td>
        <td><?php if(isset($item['driverId'])){echo $item['driverId'];}else{echo "Not Available";}?></td>
    </tr>

    <?php endforeach;?>
</table>