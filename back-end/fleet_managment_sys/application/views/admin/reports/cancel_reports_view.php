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
        <?php    $seconds_diff = (float)$item['cancelTime']->sec - (float)$item['callTime']->sec;
                $min_diff = $seconds_diff / 60;?>
        <td><?php if(isset($item['dispatchTime'])){echo date('H:m Y-m-d',$item['dispatchTime']->sec);}else{echo "Not Available";}?></td>
        <td><?php if(isset($item['cancelTime'])){echo date('H:m Y-m-d',$item['cancelTime']->sec);}else{echo "Not Available";}?></td>
        <td><?php if(isset($item['cancelTime'])){
                $seconds_diff = (float)$item['cancelTime']->sec - (float)$item['callTime']->sec;
                $timeDiff1 = $seconds_diff / 60;
                echo $timeDiff1 . ' (mins)';
            }else{
                echo "Not Available";
            }?></td>
        <td>
            <?php if(isset($item['dispatchTime'])){echo
                $seconds_diff = (float)$item['cancelTime']->sec - (float)$item['dispatchTime']->sec;
                $timeDiff2 = $seconds_diff / 60;
                echo $timeDiff2  . "(mins)";
            }
            else{
                echo "Not Available";}?>
        </td>
        <td><?= $item['croId']?></td>
        <td><?php if(isset($item['cancelUserId'])){echo $item['cancelUserId'];}else{echo "Not Available";}?></td>
        <td><?php if(isset($item['driverId'])){echo $item['driverId'];}else{echo "Not Available";}?></td>
    </tr>

    <?php endforeach;?>
</table>
