<div class="col-lg-12">

    <div class="panel panel-danger">
        <!-- Default panel contents -->
        <div class="panel-heading text-center">Not Dispatched</div>

    <table class="table table-striped" >
        <tr>
            <th>Ref #</th>
            <th>R.Q Time</th>
            <th>MR</th>
            <th>Address</th>
            <th>Agent</th>
            <th>Inquiries</th>
            <th>DIM</th>
            <th>VIH</th>
            <th>VIP</th>
            <th>Cop</th>
        </tr>

        <?php foreach ($data as $item):?>
            <?php if($item['status'] == 'START'):?>
            <tr>
                <td id="refId"><?= $item['refId'] ?></td>
                <td id="rqTime"><?= date('jS-M-y  h:i a', $item['bookTime']->sec) ?></td>
                <td id="mr">MR</td>
                <td id="address"><?= implode(", ", $item['address']) ?></td>
                <td id="agent"><?= $item['croId'] ?></td>
                <td>Inquiries</td>
                <td><?= getBadge(false) ?></td>
                <td><?= getBadge($item['isVih']) ?></td>
                <td><?= getBadge($item['isVip']) ?></td>
                <td><?= getBadge(false) ?></td>




            </tr>
            <?php endif;?>
        <?php endforeach;?>

    </table>
        </div>
    </div>
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

<?php
function getBadge($status)
{
    $status = (bool)$status;
    if ($status) {
        $returnBadge = '<span class="badge alert-info"><span style="color: #5cb85c" class="glyphicon glyphicon-ok"></span></span>';
    } else {
        $returnBadge = '<span class="badge alert-warning"><span style="color: #d9534f" class="glyphicon glyphicon-remove"></span></span>';
    }
    return $returnBadge;
}

?>
