<table class="table table-striped" >
    <tr>
        <th>Driver ID</th>
        <th>Name</th>
        <th>User Name</th>
        <th>Pass</th>
        <th>NIC</th>
        <th>tp</th>
        <th>Cab ID</th>
    </tr>

    <?php foreach ($data as $item):?>

        <tr>
            <td><?= $item['driverId'];?></td>
            <td><?= $item['name'];?></td>
            <td><?= $item['uName'];?></td>
            <td><?= $item['pass'];?></td>
            <td><?= $item['nic'];?></td>
            <td><?= $item['tp'];?></td>
            <td><?php
                if(array_key_exists("cabId", $item)){
                    echo $item['cabId'];
                }elseif(!array_key_exists("cabId", $item)){
                    echo 'empty';
                }
                ?></td>
        </tr>

    <?php endforeach;?>
</table>

