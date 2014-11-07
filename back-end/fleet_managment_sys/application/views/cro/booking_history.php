<div class="col-lg-12">
    <?php if(isset($history_booking) && sizeof($history_booking) != 0):?>
    <table class="table table-striped" ><tr>
            <th>Status</th>
            <th>Ref ID</th>
            <th>Call Time</th>
            <th>Book Time</th>
            <th>Address</th>
            <th>Driver Id</th>
            <th>Cab Id</th>
            <th>Remark</th>
        </tr>
        <?php foreach (array_reverse($history_booking) as $item):?>
        <tr>
            <td><?= $item['status'];?></td>
            <td><?= $item['refId'];?></td>
            <td><?=  date('H:i:s Y-m-d ', $item['callTime']->sec);?></td>
            <td><?=  date('H:i:s Y-m-d ', $item['bookTime']->sec);?></td>
            <td><?= $item['address']['no'] ." ". $item['address']['road'] ." ". $item['address']['city'] ." ". $item['address']['town'];?></td>
            <td><?= $item['driverId'];?></td>
            <td><?= $item['cabId'];?></td>
            <td><?= $item['remark'];?></td>
        </tr>
        <?php endforeach;?>

    </table>
    <?php endif?>

    <?php if(!isset($history_booking)):?>
        <h4>Previous History is Empty</h4>
    <?php endif;?>
</div>