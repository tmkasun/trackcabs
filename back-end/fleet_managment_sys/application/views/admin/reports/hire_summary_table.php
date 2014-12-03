<table class="table table-striped" >
    <tr>
        <th>Cab ID</th>
        <th>Calling No</th>
        <th>Time On</th>
        <th>Time Off</th>
        <th>Hire Type</th>
        <th>Remarks</th>

    </tr>


    <?php foreach ($data as $item):?>

        <tr>
            <td><?= $item['cabId'];?></td>
            <td><?= $item['callingNumber'];?></td>
            <td><?= $item['timeOn'];?></td>
            <td><?= $item['timeOut'];?>
            <td><?= $item['status'];?></td>
            <td><?= $item['remark'];?></td>

        </tr>

    <?php endforeach;?>
</table>