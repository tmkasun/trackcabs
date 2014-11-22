<table class="table table-striped" >
    <tr>
        <th>Complaint Ref ID</th>
        <th>Booking Ref ID</th>
        <th>Complaint</th>
        <th>Driver ID</th>
        <th>CRO ID (Made Booking)</th>
        <th>CRO ID (Took Complaint)</th>
        <th>Time Complaint Made</th>
        

    </tr>


    <?php foreach ($complaints as $item):?>

    <tr>
        <td><?= $item['complaintId']?></td>
        <td><?= $item['refId']?></td>
        <td><?= $item['complaint']?></td>
        <td><?= $item['userId_driver']?></td>
        <td><?= $item['userId_cro_booking']?></td>
        <td><?= $item['userId_cro_complaint']?></td>
        <td><?= date('H:m Y-m-d',$item['timeOfComplaint']->sec)?></td>
    </tr>

    <?php endforeach;?>
</table>
