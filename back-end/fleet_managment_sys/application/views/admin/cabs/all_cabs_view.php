<table class="table table-striped" >
    <tr>
        <th>CAB ID</th>
        <th>Plate Number</th>
        <th>Vehicle Type</th>
        <th>Model</th>
        <th>Info</th>
        <th>Colour</th>
        <th>User ID</th>
        <th>Calling Number</th>
        <th>Log Sheet Number</th>
        <th>Start Location</th>
    </tr>

    <?php foreach ($data as $item):?>


        <tr>
            <td><?= $item['cabId'];?></td>
            <td><?= $item['plateNo'];?></td>
            <td><?= $item['vType'];?></td>
            <td><?= $item['model'];?></td>
            <td><?php
                if(array_key_exists("info", $item)){
                    echo $item['info'];
                }elseif(!array_key_exists("info", $item)){
                    echo 'empty';
                }
                ?>
            </td>
            <td><?php
                if(array_key_exists("color", $item)){
                    echo $item['color'];
                }elseif(!array_key_exists("color", $item)){
                    echo 'empty';
                }
                ?></td>
            <td><?php if(array_key_exists('userId', $item)){if($item['userId'] == -1){echo 'Not Assigned';}else{echo $item['userId'];}}else {echo 'empty';}?></td>
            <td><?php if(array_key_exists('callingNumber', $item)){if($item['callingNumber'] == -1){echo 'Not Assigned';}else{echo $item['callingNumber'];}}else {echo 'Not Assigned';}?></td>
            <td><?php if(array_key_exists('logSheetNumber', $item)){if($item['logSheetNumber'] == -1){echo 'Not Assigned';}else{echo $item['logSheetNumber'];}}else {echo 'Not Assigned';}?></td>
            <td><?php if(array_key_exists('startLocation', $item)){if($item['startLocation'] === ""){echo 'Not Assigned';}else{echo $item['startLocation'];}}else {echo 'Not Assigned';}?></td>
        </tr>


    <?php endforeach;?>

    </table>

