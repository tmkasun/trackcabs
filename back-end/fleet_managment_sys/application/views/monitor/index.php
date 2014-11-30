<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>H&aacute;o Monitor Agent</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author"
          content="H&aacute;o City Cabs System"/>
    <meta name="description"
          content="City cabs"/>
    <meta charset="UTF-8"/>
    <meta name="keywords"
          content="H&aacute;o City Cabs System,vehicle tracking system"/>

    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/img/favicon.ico">
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">

    <script src="<?= base_url() ?>assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-ui.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/application_options.js"></script>

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
            var conn = new ab.Session('ws://' + ApplicationOptions.constance.WEBSOCKET_URL + ':' + ApplicationOptions.constance.WEBSOCKET_PORT,
                function () {
                    conn.subscribe(userid, function (topic, data) {
                        // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                        console.log('New Message published to user "' + topic + '" : ' + data.message);
                        var order = data.message;
                        debubObject = order;
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

        function updateTime() {
            /* var liveOrdersList = $('#liveOrdersList').find('a');
             var i = 0;
             for (; i < liveOrdersList.length; i++) {
             var latestBooking = $(liveOrdersList[i]);
             //        var latestBooking = $('#liveOrdersList').find('a:first');
             var latestBookingDate = latestBooking.data('booktime');
             var timeDifferent = moment.unix(latestBookingDate).diff(moment(), 'minutes', true);
             if (timeDifferent <= 30) {
             //                console.log("DEBUG: checking time interval timeDifferent = " + timeDifferent);
             latestBooking.addClass("list-group-item-danger");
             }
             else {
             //                console.log("DEBUG: fromNow = " + moment.unix(latestBookingDate).fromNow() + " checking time interval timeDifferent = " + timeDifferent);
             }
             latestBooking.find('.fromNow').html('(' + moment.unix(latestBookingDate).fromNow() + ')');
             }*/
        }

        (function ($) {
            $(window).load(function () {
                moment().format();
                updateTime();
                setInterval(updateTime, 1000);
            });
        })(jQuery);

        subscribe('monitor1');

    </script>

</head>
<body>


<nav class="navbar navbar-inverse" role="navigation" style="background-color: floralwhite;">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><img style="max-width:50px; margin-top: -7px;"
                                              src="<?= base_url() ?>assets/img/hao-logo-small.png"/></a>

    </div>
    <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li>
                <form action="#" style="margin: 0px;padding-right: 5px;">
                    <a class="btn btn-sm btn-success navbar-btn" href="/">Home</a>
                </form>
            </li>

        </ul>

    </div>
</nav>


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
            <th>Inquiries</th>
            <th>DIM</th>
            <th>VIH</th>
            <th>VIP</th>
            <th>Cop</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $orders_list = array();
        foreach ($orders as $order) {

            switch ($order['status']) {
                case "START":
                    empty($orders_list['START']) ? $orders_list['START'] = array($order) : array_push($orders_list['START'], $order);
                    break;
                case "MSG_NOT_COPIED":
                    empty($orders_list['MSG_NOT_COPIED']) ? $orders_list['MSG_NOT_COPIED'] = array($order) : array_push($orders_list['MSG_NOT_COPIED'], $order);
                    break;
                case "MSG_COPIED":
                    empty($orders_list['MSG_COPIED']) ? $orders_list['MSG_COPIED'] = array($order) : array_push($orders_list['MSG_COPIED'], $order);
                    break;
                case "AT_THE_PLACE":
                    empty($orders_list['AT_THE_PLACE']) ? $orders_list['AT_THE_PLACE'] = array($order) : array_push($orders_list['AT_THE_PLACE'], $order);
                    break;
                case "POB":
                    empty($orders_list['POB']) ? $orders_list['POB'] = array($order) : array_push($orders_list['POB'], $order);
                    break;
                case "IDLE":
                    empty($orders_list['IDLE']) ? $orders_list['IDLE'] = array($order) : array_push($orders_list['IDLE'], $order);
                    break;
                default:
                    echo "";
            }

        }
        if (!empty($orders_list['START'])):
            foreach ($orders_list['START'] as $order): ?>
                <tr id="<?= $order['refId'] ?>">
                    <td id="refId"><?= $order['refId'] ?></td>
                    <td id="rqTime"><?= date('jS-M-y  h:i a', $order['bookTime']->sec) ?></td>
                    <td id="mr">MR</td>
                    <td id="address"><?= implode(", ", $order['address']) ?></td>
                    <td id="agent"><?= $order['croId'] ?></td>
                    <td>Inquiries</td>
                    <td><?= getBadge(false) ?></td>
                    <td><?= getBadge($order['isVih']) ?></td>
                    <td><?= getBadge($order['isVip']) ?></td>
                    <td><?= getBadge(false) ?></td>
                </tr>
            <?php endforeach; endif ?>
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
            <th>Cab #</th>
            <th>Driver mobile</th>
            <th>Address</th>
            <th>Agent</th>
            <th>Inquiries</th>
            <th>DIM</th>
            <th>VIH</th>
            <th>VIP</th>
            <th>Cop</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($orders_list['MSG_NOT_COPIED'])):
            foreach ($orders_list['MSG_NOT_COPIED'] as $order): ?>
                <tr id="<?= $order['refId'] ?>">
                    <td id="refId"><?= $order['refId'] ?></td>
                    <td id="rqTime"><?= date('jS-M-y  h:i a', $order['bookTime']->sec) ?></td>
                    <td id="mst"><?= date('jS-M-y  h:i a', $order['dispatchTime']->sec) ?></td>
                    <td id="cabId"><?= $order['cabId'] ?></td>

                    <td id="driverMobile"><?php $driver = $this->user_dao->getUser($order['driverId'], 'driver');
                        echo($driver['tp']) ?></td>

                    <td id="address"><?= implode(", ", $order['address']) ?></td>
                    <td id="agent"><?= $order['croId'] ?></td>
                    <td>Inquiries</td>
                    <td><?= getBadge(false) ?></td>
                    <td><?= getBadge($order['isVih']) ?></td>
                    <td><?= getBadge($order['isVip']) ?></td>
                    <td><?= getBadge(false) ?></td>
                </tr>
            <?php endforeach; endif; ?>
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
            <th>Message copied time</th>
            <th>Cab #</th>
            <th>Driver mobile</th>
            <th>Address</th>
            <th>Agent</th>
            <th>Inquiries</th>
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
            <th>Message copied time</th>
            <th>Cab #</th>
            <th>Driver mobile</th>
            <th>Address</th>
            <th>Agent</th>
            <th>Inquiries</th>
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
            <th>Inquiries</th>
            <th>DIM</th>
            <th>VIH</th>
            <th>VIP</th>
            <th>Cop</th>

            <th>Location</th>
            <th>Dispatcher</th>
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