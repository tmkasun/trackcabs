<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>H&aacute;o Monitor Agent</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author"
          content="H&aacute;o City Cabs System"/>
    <meta name="description"
          content="Geo-Dashboard"/>
    <meta charset="UTF-8"/>
    <meta name="keywords"
          content="H&aacute;o City Cabs System,vehicle tracking system"/>

    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/img/favicon.ico">
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">

    <script src="<?= base_url() ?>assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-ui.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>

    <!-- autobahn websocket and WAMP -->
    <script src="<?= base_url() ?>assets/js/autobahn/autobahn.min.js"></script>

    <!-- Moment libraries -->
    <script src="<?= base_url() ?>assets/js/moment/moment.js"></script>

    <!-- UIkit libraries -->
    <script src="<?= base_url() ?>assets/js/uikit/uikit.min.js"></script>
    <script src="<?= base_url() ?>assets/js/uikit/addons/notify.min.js"></script>

    <!-- UIkit CSS libraries -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/uikit/uikit.min.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/uikit/addons/uikit.addons.min.css"/>

    <!-- autobahn websocket and WAMP -->
    <script src="<?= base_url() ?>assets/js/websocket/monitor.js"></script>

    <script>
        function subscribe(userid) {
            console.log("DEBUG: userid = " + userid);
            var conn = new ab.Session('ws://'+ApplicationOptions.constance.WEBSOCKET_URL+':'+ApplicationOptions.constance.WEBSOCKET_PORT,
                function () {
                    conn.subscribe(userid, function (topic, data) {
                        // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                        console.log('New Message published to user "' + topic + '" : ' + data.message);
                        var order = data.message;
                        debugObject = order;
                        if (order.status === "START") {
                            addToNotDispatch(order);
                        } else if (order.status === "MSG_NOT_COPIED") {
                            addToMsgNotCopied(order);
                        } else if (order.status === "CANCEL") {
                            removeOrderFromMonitor(order);
                        }

                    });
                },
                function () {
                    console.warn('WebSocket connection closed');
                },
                {'skipSubprotocolCheck': true}
            );
        }
        subscribe('monitor1');

    </script>

</head>
<body>
<div class="container" style="width: 100%">
<div class="row text-center text-info">
    Monitor all
</div>
<div class="panel panel-danger">
    <!-- Default panel contents -->
    <div class="panel-heading text-center">Not Dispatched</div>

    <!-- Table -->
    <table class="table" id="START">
        <thead>
        <tr>
            <th>Ref #</th>
            <th>R.Q Time</th>
            <th>MR</th>
            <th>Address</th>
            <th>Agent</th>
            <th>Inquire</th>
            <th>With count</th>
            <th>DIM</th>
            <th>VIH</th>
            <th>VIP</th>
            <th>Cop</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <tr id="<?= $order['refId'] ?>">
                <td id="refId"><?= $order['refId'] ?></td>
                <td id="rqTime"><?= date('jS-M-y  h:i a', $order['bookTime']->sec) ?></td>
                <td id="mr">MR</td>
                <td id="address"><?= implode(", ", $order['address']) ?></td>
                <td id="agent"><?= $order['croId'] ?></td>
                <td>Inquire</td>
                <td>With count</td>
                <td><?= getBadge(false) ?>??</td>
                <td><?= getBadge($order['isVih']) ?></td>
                <td><?= getBadge($order['isVip']) ?></td>
                <td><?= getBadge(false) ?>??</td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>


<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading text-center">Message not copied</div>

    <!-- Table -->
    <table class="table" id="MSG_NOT_COPIED">
        <thead>
        <tr>
            <th>Ref #</th>
            <th>R.Q Time</th>
            <th>MST</th>
            <th>SMS Time</th>
            <th>MR</th>
            <th>Cab #</th>
            <th>Driver mobile</th>
            <th>Address</th>
            <th>Agent</th>
            <th>Inquire</th>
            <th>DIM</th>
            <th>VIH</th>
            <th>VIP</th>
            <th>Cop</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<div class="panel panel-success">
    <!-- Default panel contents -->
    <div class="panel-heading text-center">On the Way</div>

    <!-- Table -->
    <table class="table" id="MSG_COPIED">
        <thead>
        <tr>
            <th>Ref #</th>
            <th>R.Q Time</th>
            <th>MCT</th>
            <th>Message copied time</th>
            <th>MR</th>
            <th>Cab #</th>
            <th>Driver mobile</th>
            <th>Address</th>
            <th>Agent</th>
            <th>Inquire</th>
            <th>DIM</th>
            <th>VIH</th>
            <th>VIP</th>
            <th>Cop</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<div class="panel panel-info">
    <!-- Default panel contents -->
    <div class="panel-heading text-center">At the Place</div>

    <!-- Table -->
    <table class="table" id="AT_THE_PLACE">
        <thead>
        <tr>
            <th>Ref #</th>
            <th>R.Q Time</th>
            <th>MCT</th>
            <th>Message copied time</th>
            <th>MR</th>
            <th>Cab #</th>
            <th>Driver mobile</th>
            <th>Address</th>
            <th>Agent</th>
            <th>Inquire</th>
            <th>DIM</th>
            <th>VIH</th>
            <th>VIP</th>
            <th>Cop</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<div class="panel panel-warning">
    <!-- Default panel contents -->
    <div class="panel-heading text-center">POB</div>

    <!-- Table -->
    <table class="table" id="POB">
        <thead>
        <tr>
            <th>Ref #</th>
            <th>R.Q Time</th>
            <th>POB Time</th>
            <th>On hire time</th>
            <th>Cab #</th>
            <th>Driver mobile</th>
            <th>Address</th>
            <th>Agent</th>
            <th>Inquire</th>
            <th>DIM</th>
            <th>VIH</th>
            <th>VIP</th>
            <th>Cop</th>

            <th>Location</th>
            <th>Info Dispatcher</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading text-center">Free checker</div>

    <!-- Table -->
    <table class="table" id="IDLE">
        <thead>
        <tr>
            <th>Driver #</th>
            <th>Hire Finished Time</th>
            <th>Location</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

</div>
</body>
</html>
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