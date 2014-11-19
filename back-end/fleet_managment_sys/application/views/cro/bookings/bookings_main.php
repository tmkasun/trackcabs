<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-------------------------------- CSS Files------------------------------------>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/webLibs/bootstrapvalidator-dist-0.5.2/dist/css/bootstrapValidator.css">

    <!-------------------------------- JS Files------------------------------------>
    <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/cro_operations.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/bootstrapvalidator-dist-0.5.2/dist/js/bootstrapValidator.js" charset="UTF-8"></script>


    <script>
        var docs_per_page= 100 ;
        var page = 1 ;
        var obj = null;
        var tp;
        var url = '<?= site_url(); ?>';
        var bookingObj = null;
        var customerObj = null;
    </script>
</head>
<body>
<div id="navBarField">
    <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Hao Cabs</a>
        </div>

        <ul class="nav navbar-nav">
            <li ><a href="<?= site_url('cro_controller')?>">CRO</a></li>
            <li><a href="<?= site_url('cro_controller/loadMyBookingsView')?>" >My Bookings</a></li>
            <li class="active"><a href="<?= site_url('cro_controller/loadBookingsView')?>" >Bookings</a></li>
            <li><a href="<?= site_url('cro_controller/loadMapView')?>" >Map</a></li>
            <li><a href="<?= site_url('cro_controller/loadLocationBoardView')?>" >Location Board</a></li>
            <li><a href="<?= site_url('cro_controller/loadPOBBoardView')?>" >POB Board</a></li>
            <li><a href="<?= site_url('cro_controller/refresh')?>" >Refresh</a></li>
        </ul>



        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $uName;?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= site_url('login/logout')?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</div>

<div class="container-fluid">

    <div class="row" style="background: #d7ddeb; min-height: 1000px">


        <div class="col-lg-12" style="margin-top: 10px;" id="bookingSearch" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Booking Search</h5>
                </div>

                <div class="panel-body" >

                    <div class="col-lg-4">
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <label for="refIdSearch" class="sr-only">Reference ID</label>
                                <input type="text" class="form-control" id="refIdSearch" placeholder="REF ID">
                            </div>
                            <button type="submit" class="btn btn-default" onsubmit="bookingsOperations('getBookingById');return false;" onclick="bookingsOperations('getBookingById');return false;">Search</button>
                        </form>
                    </div>

                    <div class="col-lg-4">
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <label for="inputPassword2" class="sr-only">Password</label>
                                <input type="text" class="form-control" id="inputPassword2" placeholder="Customer Name">
                            </div>
                            <button type="submit" class="btn btn-default">Search</button>
                        </form>
                    </div>

                    <div class="col-lg-4">
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <label for="townSearch" class="sr-only">Address[Town]</label>
                                <input type="text" class="form-control" id="townSearch" placeholder="Address[Town]">
                            </div>
                            <button type="submit" class="btn btn-default" onsubmit="bookingsOperations('getBookingByTown');return false;" onclick="bookingsOperations('getBookingByTown');return false;">Search</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-12" style="margin-top: 10px" id="searchDetails">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Search Details</h5>
                </div>

                <div class="panel-body" >




                    <div class="col-lg-12" style="border: 2px solid #a6a6a6;padding-left: 2px; padding-right: 2px">
                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Status
                            </div>
                            <div class="col-lg-8">
                                <span id="jobStatus"><?= $live_booking[$index]['status']; ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Reference ID
                            </div>
                            <div class="col-lg-8">
                                <span id="jobRefId"><?= $live_booking[$index]['refId']; ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Driver ID
                            </div>
                            <div class="col-lg-8">
                                <span id="jobDriverId"><?php if($live_booking[$index]['driverId'] == '-' )echo 'NOT_ASSIGNED';else echo $live_booking[$index]['driverId'];?></span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Cab ID
                            </div>
                            <div class="col-lg-8">
                                <span id="jobCabId"><?php if($live_booking[$index]['cabId'] == '-' )echo 'NOT_ASSIGNED';else $live_booking[$index]['cabId']; ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Vehicle Type
                            </div>
                            <div class="col-lg-8">
                                <span id="jobVehicleType"><?= $live_booking[$index]['vType']; ?></span>
                            </div>
                        </div>

                        <div class="col-lg-offset-8 col-lg-5">
                            <button type="button" class="btn btn-primary " onclick="operations('editBooking', '<?= $live_booking[$index]['_id'];?>')">Update</button>
                            <button type="button" class="btn btn-default" onclick="operations('cancel', '<?= $live_booking[$index]['_id'];?>')">Cancel</button>

                        </div>

                    </div>

                    <div class="col-lg-12" style="border: 2px solid #a6a6a6;padding-left: 2px; padding-right: 2px ; margin-top: 2px ">
                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Address
                            </div>
                            <div class="col-lg-8">
                                    <span id="jobAddress">
                                        <?= $live_booking[$index]['address']['no'] ." ".
                                        $live_booking[$index]['address']['road'] ." ".
                                        $live_booking[$index]['address']['city'] ." ".
                                        $live_booking[$index]['address']['town'];?>
                                    </span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Destination
                            </div>
                            <div class="col-lg-8">
                                <span id="jobDestination"><?= $live_booking[$index]['destination']?></span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Remark
                            </div>
                            <div class="col-lg-8">
                                <span id="jobRemark"><?= $live_booking[$index]['remark']?></span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Specifications
                            </div>
                            <div class="col-lg-8">
                                    <span id="jobSpecifications"> <?php if($live_booking[$index]['isVip'])echo 'VIP | ';?>
                                        <?php if($live_booking[$index]['isVih'])echo  'VIH | ';?>
                                        <?php if($live_booking[$index]['isUnmarked']) echo 'UNMARK |'?>
                                        <?php if($live_booking[$index]['isTinted']) echo 'Tinted'?>
                                    </span>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12" style="border: 2px solid #a6a6a6;padding-left: 2px; padding-right: 2px; margin-top: 2px">

                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                Book Time
                            </div>
                            <div class="col-lg-8">
                                <span id="jobBookTime"><?php echo date('H:i Y-m-d ', $live_booking[$index]['bookTime']->sec);?></span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                Call Time
                            </div>
                            <div class="col-lg-8">
                                <span id="jobCallTime"><?php echo date('H:i Y-m-d ', $live_booking[$index]['callTime']->sec);?></span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                Dispatch Before
                            </div>
                            <div class="col-lg-8">
                                    <span id="jobDispatchB4"><?= $live_booking[$index]['dispatchB4'];?> min
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12" style="border: 2px solid #a6a6a6;padding-left: 2px; padding-right: 2px ; margin-top: 2px">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                Driver Mobile
                            </div>
                            <div class="col-lg-8">
                                <span id="jobDriverTp"><?= $live_booking[$index]['driverTp'];?></span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                Cab Color
                            </div>
                            <div class="col-lg-8">
                                <span id="jobCabColor"><?= $live_booking[$index]['cabColor'];?></span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                Plate No
                            </div>
                            <div class="col-lg-8">
                                <span id="jobCabPlateNo"><?= $live_booking[$index]['cabPlateNo'];?></span>
                            </div>
                        </div>
                    </div>





                </div>
            </div>
        </div>
    </div>

    <script>

        function bookingsOperations(request){

            if(request == 'getBookingById'){
                url = url + '/customer_retriever/getBookingByRefId';
                alert(url);
                var refId= $('#refIdSearch').val();
                var  data={'refId' : refId}
                var result = ajaxPost(data , url , false);
                alert(JSON.stringify(result));
            }

            if(request == 'getBookingByTown'){
                url = url + '/customer_retriever/getBookingByRefTown';
                alert(url);
                var town= $('#townSearch').val();
                var  data={'town' : town}
                var result = ajaxPost(data , url , false);
                alert(JSON.stringify(result));
            }

            if(request == 'getBookingByCustomer'){

            }
        }


        function ajaxPost(data,urlLoc, asynchronicity)    {
            var result=null;
            $.ajax({
                type: 'POST', url: urlLoc,
                contentType: 'application/json; charset=utf-8',
                data: JSON.stringify(data),
                async: asynchronicity ? true : false,
                success: function(data, textStatus, jqXHR) {
                    result = JSON.parse(jqXHR.responseText);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if(jqXHR.status == 400) {
                        var message= JSON.parse(jqXHR.responseText);
                        $('#messages').empty();
                        $.each(messages, function(i, v) {
                            var item = $('<li>').append(v);
                            $('#messages').append(item);
                        });
                    } else {
                        alert('Unexpected server error.');
                    }
                }
            });
            return result;
        }

    </script>

</body>
</html>