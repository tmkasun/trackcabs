<div class="col-lg-12">
    <h3>NOT DISPATCHED</h3>
    <table class="table table-striped" >
        <tr>
            <th>Ref Id</th>
            <th>RQ Time</th>
            <th>RQ Date</th>
            <th>Address</th>
        </tr>

        <?php foreach ($data as $item):?>
            <?php if($item['status'] = 'START'):?>
            <tr>
                <td class="col-md-1"><?= $item['refId'];?></td>
                <td class="col-md-1"><?php echo date('H:i:s Y-m-d ', $item['callTime']->sec);?></td>
                <td class="col-md-2"><?php echo date('H:i:s Y-m-d ', $item['bookTime']->sec);?></td>
                <td class="col-md-6"><?php echo $item['address']['no'] ." ". $item['address']['road'] ." ". $item['address']['city'] ." ". $item['address']['town'];?></td>
            </tr>
            <?php endif;?>
        <?php endforeach;?>

    </table>
</div>
