<table class="table table-striped" >
    <tr>
        <th>Driver ID</th>
        <th>Login Time</th>
        <th>Logout Time</th>
        <th>Working hours</th>


    </tr>


    <?php foreach ($data as $item):?>

        <tr>
            <td><?= $item['driverId'];?></td>
            <td><?php $timeIn=$item['time'];
                echo date('h:i:s', $timeIn->sec);
                ?></td>
            <td><?php $timeOut=$item['logout_time'];
                if($timeOut=='-'){
                    $timeOut = new MongoDate();
                    echo 'not logged out';
                }else{
                    echo date('h:i:s', $timeOut->sec);
                }
                ?></td>
            <td><?php $workingHour=$item['workingHours']/3600;
                    if($workingHour<24){
                        echo $workingHour."hours";
                    }else{
                        echo ($workingHour/24)." days ".($workingHour%24)." hours";
                    }
                ?></td>

        </tr>

    <?php endforeach;?>
</table>