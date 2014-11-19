<div class="col-lg-12">
    <h3>NOT DISPATCHED</h3>
    <table class="table table-striped" >
        <tr>
            <th>Ref Id</th>
            <th>RQ Time</th>
            <th>RQ Date</th>
            <th>Address</th>
            <th>Address</th>
        </tr>

        <?php foreach ($data as $item):?>
            <?php if($item['status'] == 'START'):?>
            <tr>
                <td><?= $item['refId'];?></td>
                <td><?php echo date('H:i:s Y-m-d ', $item['callTime']->sec);?></td>
                <td><?php echo date('H:i:s Y-m-d ', $item['bookTime']->sec);?></td>
                <td><?php echo $item['address']['no'] ." ". $item['address']['road'] ." ". $item['address']['city'] ." ". $item['address']['town'];?></td>
            </tr>
            <?php endif;?>
        <?php endforeach;?>

    </table>
</div>

<div class="col-lg-12">
    <h3>MSG NOT COPIED</h3>
    <table class="table table-striped" >
        <tr>
            <th>Ref Id</th>
            <th>RQ Time</th>
            <th>RQ Date</th>
            <th>Address</th>
        </tr>

        <?php foreach ($data as $item):?>
            <?php if($item['status'] == 'MSG_NOT_COPIED'):?>
                <tr>
                    <td><?= $item['refId'];?></td>
                    <td><?php echo date('H:i:s Y-m-d ', $item['callTime']->sec);?></td>
                    <td><?php echo date('H:i:s Y-m-d ', $item['bookTime']->sec);?></td>
                    <td><?php echo $item['address']['no'] ." ". $item['address']['road'] ." ". $item['address']['city'] ." ". $item['address']['town'];?></td>
                </tr>
            <?php endif;?>
        <?php endforeach;?>

    </table>
</div>

<div class="col-lg-12">
    <h3>MSG COPIED</h3>
    <table class="table table-striped" >
        <tr>
            <th>Ref Id</th>
            <th>RQ Time</th>
            <th>RQ Date</th>
            <th>Address</th>
        </tr>

        <?php foreach ($data as $item):?>
            <?php if($item['status'] == 'MSG_COPIED'):?>
                <tr>
                    <td><?= $item['refId'];?></td>
                    <td><?php echo date('H:i:s Y-m-d ', $item['callTime']->sec);?></td>
                    <td><?php echo date('H:i:s Y-m-d ', $item['bookTime']->sec);?></td>
                    <td><?php echo $item['address']['no'] ." ". $item['address']['road'] ." ". $item['address']['city'] ." ". $item['address']['town'];?></td>
                </tr>
            <?php endif;?>
        <?php endforeach;?>

    </table>
</div>

<div class="col-lg-12">
    <h3>POB</h3>
    <table class="table table-striped" >
        <tr>
            <th>Ref Id</th>
            <th>RQ Time</th>
            <th>RQ Date</th>
            <th>Address</th>
        </tr>

        <?php foreach ($data as $item):?>
            <?php if($item['status'] == 'POB'):?>
                <tr>
                    <td><?= $item['refId'];?></td>
                    <td><?php echo date('H:i:s Y-m-d ', $item['callTime']->sec);?></td>
                    <td><?php echo date('H:i:s Y-m-d ', $item['bookTime']->sec);?></td>
                    <td><?php echo $item['address']['no'] ." ". $item['address']['road'] ." ". $item['address']['city'] ." ". $item['address']['town'];?></td>
                </tr>
            <?php endif;?>
        <?php endforeach;?>

    </table>
</div>
