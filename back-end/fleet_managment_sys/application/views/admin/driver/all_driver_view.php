<table class="table table-striped" >
    <tr>
        <th>Driver ID</th>
        <th>Name</th>
        <th>User Name</th>
        <th>Pass</th>
        <th>NIC</th>
        <th>tp</th>
        <th>Can Logout</th>
        <th>Cab ID</th>
    </tr>

    <?php foreach ($data as $item):?>

        <tr>
            <td><?= $item['userId'];?></td>
            <td><?= $item['name'];?></td>
            <td><?= $item['uName'];?></td>
            <td><?= $item['pass'];?></td>
            <td><?= $item['nic'];?></td>
            <td><?= $item['tp'];?></td>
            <td><?= $item['logout'];?></td>
            <td><?php
                if(!array_key_exists("cabId", $item) || $item['cabId'] === ""){
                    echo 'empty';
                }else{
                    echo $item['cabId'];
                }
                ?></td>
        </tr>

    <?php endforeach;?>
</table>

