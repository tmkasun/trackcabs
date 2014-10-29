<table class="table table-striped" >
    <tr>
        <th>CRO ID</th>
        <th>Name</th>
        <th>User Name</th>
        <th>Pass</th>
        <th>NIC</th>
        <th>tp</th>
    </tr>


    <?php foreach ($data as $item):?>

        <tr>
            <td><?= $item['croId'];?></td>
            <td><?= $item['name'];?></td>
            <td><?= $item['uName'];?></td>
            <td><?= $item['pass'];?></td>
            <td><?= $item['nic'];?></td>
            <td><?= $item['tp'];?></td>

        </tr>

    <?php endforeach;?>
</table>