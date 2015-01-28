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
            

        </tr>

    <?php endforeach;?>
</table>