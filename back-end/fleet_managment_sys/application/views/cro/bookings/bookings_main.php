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
            <li><a href="<?= site_url('cro_controller/refresh')?>" >Refresh</a></li>
            <li><a href="<?= site_url('cro_controller/getCabHeaderView')?>" >Cabs</a>
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

                <div class="col-lg-6">
                    <div class="col-lg-12" style="border: 2px solid #a6a6a6;padding-left: 2px; padding-right: 2px">

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Status
                            </div>
                            <div class="col-lg-8">
                                <span id="jobStatus">START</span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Reference ID
                            </div>
                            <div class="col-lg-8">
                                <span id="jobRefId">12</span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Driver ID
                            </div>
                            <div class="col-lg-8">
                                <span id="jobDriverId">NOT_ASSIGNED</span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Cab ID
                            </div>
                            <div class="col-lg-8">
                                <span id="jobCabId">NOT_ASSIGNED</span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Vehicle Type
                            </div>
                            <div class="col-lg-8">
                                <span id="jobVehicleType">CAR</span>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12" style="border: 2px solid #a6a6a6;padding-left: 2px; padding-right: 2px ; margin-top: 2px ">
                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Address
                            </div>
                            <div class="col-lg-8">
                                    <span id="jobAddress">
                                        8/2 , Viahara Road , Mount Lavania
                                    </span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Destination
                            </div>
                            <div class="col-lg-8">
                                <span id="jobDestination">Wellawatta</span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Remark
                            </div>
                            <div class="col-lg-8">
                                <span id="jobRemark">english speaking driver</span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px ">
                            <div class="col-lg-4">
                                Specifications
                            </div>
                            <div class="col-lg-8">
                                    <span id="jobSpecifications">
                                        VIP , VIH , VIA
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
                                <span id="jobBookTime">12/10/2014</span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                Call Time
                            </div>
                            <div class="col-lg-8">
                                <span id="jobCallTime">52/89/2014</span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                Dispatch Before
                            </div>
                            <div class="col-lg-8">
                                    <span id="jobDispatchB4">30 min
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12" style="border: 2px solid #a6a6a6;padding-left: 2px; padding-right: 2px ; margin-top: 2px">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                Driver Mobile
                            </div>
                            <div class="col-lg-8">
                                <span id="jobDriverTp">123</span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                Cab Color
                            </div>
                            <div class="col-lg-8">
                                <span id="jobCabColor">456</span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                Plate No
                            </div>
                            <div class="col-lg-8">
                                <span id="jobCabPlateNo">879</span>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-offset-7 col-lg-5" style="margin-top: 5px">
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Update
                                </button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" >
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">Customer Details</h3>
                        </div>
                        <div class="panel-body" id="bookingStatus">
                            <p>Name : Mr.Nirojan Selvanathan</p>
                            <p>Telephone 1 : 0779823445</p>
                            <p>Telephone 2 : 0112732270</p>
                            <p>Permenant Remark: English Speaking Driver</p>
                            <p>Organizatiuon: WSO2</p>
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