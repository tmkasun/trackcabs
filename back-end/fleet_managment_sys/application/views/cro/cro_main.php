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
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/uikit/uikit.min.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/uikit/addons/uikit.addons.min.css"/>

    <!-------------------------------- JS Files------------------------------------>
    <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/cro_operations.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/bootstrapvalidator-dist-0.5.2/dist/js/bootstrapValidator.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/knockout/knockout-3.2.0.js"></script>

    <!-- UIkit libraries -->
    <script src="<?= base_url() ?>assets/js/uikit/uikit.min.js"></script>
    <script src="<?= base_url() ?>assets/js/uikit/addons/notify.min.js"></script>


    <script src="<?= base_url() ?>assets/js/application_options.js"></script>
    <script>
        setBaseURL('<?= base_url().'index.php/' ?>'); // TODO: use better method to set BASE_URL infact set all dynamic vars, in here order matters caz initializing applicatioOptions
    </script>

    <!-- autobahn websocket and WAMP -->
    <script src="<?= base_url() ?>assets/js/autobahn/autobahn.min.js"></script>


    <script>
        var docs_per_page= 100 ;
        var page = 1 ;
        var obj = null;
        var tp;
        var url = '<?= site_url(); ?>';
        var bookingObj = null;
        var historyBookingObj = null;
        var customerObj = null;

        function subscribe(userid) {
            var conn = new ab.Session(
                'ws://' + ApplicationOptions.constance.WEBSOCKET_URL + ':' + ApplicationOptions.constance.WEBSOCKET_PORT,
                function () {
                    conn.subscribe(userid, function (topic, data) {
                        // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                        console.log('New Message published to user "' + topic + '" : ' + data.message);
                        var messageData = data.message;
                        debugObject = $.UIkit.notify({
                            message: "Order # = <span onclick='$(\"#tpSearch\").val(\""+messageData.tp+"\")' style='cursor: pointer;color: red'>"+messageData.refId+"</span> request to delay in <span style='color: #0000FF'>"+ messageData.delay_minutes+" minutes</span> from cro(ID): "+messageData.croId,
                            status: 'warning',
                            timeout: 0,
                            pos: 'top-center'
                        });
                    });
                },
                function () {
                    console.warn('WebSocket connection closed');
                },
                {'skipSubprotocolCheck': true}
            );
        }

        subscribe('cro1');
        </script>
</head>
<body>
<div id="navBarField">
    <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Hao Cabs - CRO</a>
        </div>

        <ul class="nav navbar-nav">
            <li class="navbar-form navbar-left" style="padding: 0">  <!--<a href="<?/*= site_url('cro_controller')*/?>">CRO</a>-->



                <div class="btn-group">
                    <button type="button" data-bind="click:updateNumbers" class="btn btn-success dropdown-toggle cabView" data-toggle="dropdown" >
                        <span>Get Number</span>
                        <span class="caret"></span>
                    </button>

                    <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; border-radius: 5px">

                        <div style="margin:0">
                            <table class="table table-hover" style="margin-bottom:2%">
                                <thead>
                                <tr>
                                    <th style="text-align: right; min-width: 97px">Time</th>
                                    <th>Number</th>
                                    <th>State</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody data-bind="foreach:currentNumbers">
                                <tr>
                                    <td data-bind="text:readableTimeStamp" style="padding: 13px; text-align: right;"><span>2014/10/23</span></td>
                                    <td data-bind="text:number" style="padding: 13px ; text-align: right;"><span>0772866596</span></td>
                                    <td data-bind="text:state" style="padding: 13px; text-align: right;"><span>Answered</span></td>
                                    <td ><button data-bind="click:$root.assignNumber" class="btn btn-default">Assign Number</button></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>



            </li>

            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="tel" class="form-control" placeholder="Mobile / LandLine" id="tpSearch" autofocus>
                </div>
                <input type="submit" id="submitNumber" class="btn btn-default" onclick="operations('getCustomer');return false" onsubmit="operations('getCustomer');return false" value="Submit" />
            </form>

            <li><a href="<?= site_url('cro_controller/loadMyBookingsView')?>" >My Bookings</a></li>
            <li><a href="<?= site_url('cro_controller/loadBookingsView')?>" >Bookings</a></li>
            <li><a href="<?= site_url('cro_controller/loadMapView')?>" >Map</a></li>
            <li><a href="<?= site_url('cro_controller/loadLocationBoardView')?>" >Location Board</a></li>
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

        <div class="col-lg-6" style="margin-top: 10px" id="customerInformation">

            <div class="panel panel-default" xmlns="http://www.w3.org/1999/html">
                <div class="panel-heading">
                    <h3 class="panel-title">Customer Information</h3>
                </div>
                <div class="panel-body" >
                    <div class="col-md-12" style="padding: 1px">

                        <div class="col-lg-3" style="padding: 1px">
                            <img style='float:left;width:134px;height:128px' src="<?= base_url() ?>assets/img/profile_pic.jpg" />
                            <div class="col-lg-12" style="margin-top: 5px ; padding: 1px">

                                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default btn-sm" onclick="operations('editCus', '<?= $tp;?>' )">
                                            <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Update
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-9" style="padding: 1px">
                            <div class="col-lg-12">
                                <span class="col-lg-3">Name</span>
                                <span class="col-lg-9">Mr (Dig) . Nirojan Selvanathan</span>
                            </div>

                            <div class="col-lg-12">
                                <span class="col-lg-3">Remark[P]</span>
                                <span class="col-lg-9">Need an English speaking driver nad herohwoihosdn gosdh  dhs follkh ohi olh </span>
                            </div>

                            <div class="col-lg-12">
                                <span class="col-lg-3">Organization</span>
                                <span class="col-lg-9">WSO2</span>
                            </div>

                            <div class="col-lg-12">
                                <span class="col-lg-3">Profile</span>
                                <span class="col-lg-9">Personal</span>
                            </div>

                            <div class="col-lg-12">
                                <span class="col-lg-3">Job Count</span>
                                <span class="col-lg-9">12</span>
                            </div>

                            <div class="col-lg-12">
                                <span class="col-lg-3">Cancel [T]</span>
                                <span class="col-lg-9">12</span>
                            </div>

                            <div class="col-lg-12">
                                <span class="col-lg-3">Cancel [D]</span>
                                <span class="col-lg-9">12</span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="col-lg-offset-4 col-lg-8" style="padding: 1px">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="cooperateUserTp" placeholder="Land / Mobile">
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="operations('addUser');return false;" onsubmit="operations('addUser');return false;">Add User</button>
                                  </span>
                                </div><!-- /input-group -->
                            </div>

                            <div class="col-lg-12">

                            </div>
                        </div>

                    </div>
                </div>




            <div class="col-lg-offset-3 col-lg-7" style="margin-top: 10%">
                <!--img style="width: 80%" src="<?= base_url() ?>assets/img/hao-logo-small.png"-->
            </div>
        </div>
            </div>

        <div class="col-lg-6" style="margin-top: 10px;" id="jobInfo" >



            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Job Information</h5>
                </div>
                <div class="panel-body" >
                    <div class="col-lg-12" style="padding-left: 1px; padding-right: 1px;">

                        <div class="panel panel-default col-lg-5" style="padding: 1px">
                            <div class="panel-body" style="padding: 1px">
                                <div class="col-lg-12">
                                    <span class="col-lg-4" style="padding: 1px">Status</span>
                                    <span id="jobStatus" class="col-lg-8" style="padding: 1px">
                                        <span class="label label-default">START</span>
                                    </span>
                                </div>

                                <div class="col-lg-12">
                                    <span class="col-lg-4" style="padding: 1px">Ref. ID</span>
                                    <span class="col-lg-8" style="padding: 1px"><span class="badge" id="jobRefId" >42</span></span>
                                </div>


                                <div class="col-lg-12">
                                    <span class="col-lg-4" style="padding: 1px">V Type</span>
                                    <span id="jobVehicleType" class="col-lg-8" style="padding: 1px">Van</span>
                                </div>


                                <div class="col-lg-12">
                                    <span class="col-lg-4" style="padding: 1px">Payment</span>
                                    <span id="jobPayType" class="col-lg-8" style="padding: 1px">Cash</span>
                                </div>

                                <div class="col-lg-12" style="padding: 1px">
                                    <div class="well well-sm"><span class="col-lg-offset-3">Vehicle Details</span> </div>
                                </div>

                                <div class="col-lg-12">
                                    <span class="col-lg-4" style="padding: 1px">Driver ID</span>
                                    <span id="jobDriverId" class="col-lg-8" style="padding: 1px">NOT_ASSIGNED</span>
                                </div>

                                <div class="col-lg-12">
                                    <span class="col-lg-4" style="padding: 1px">Cab ID</span>
                                    <span id="jobCabId" class="col-lg-8" style="padding: 1px">NOT_ASSIGNED</span>
                                </div>

                                <div class="col-lg-12">
                                    <span class="col-lg-4" style="padding: 1px">Driver Tp</span>
                                    <span id="jobStatus" class="col-lg-8" style="padding: 1px">0779823445</span>
                                </div>

                                <div class="col-lg-12">
                                    <span class="col-lg-4" style="padding: 1px">Cab Color</span>
                                    <span id="jobRefId" class="col-lg-8" style="padding: 1px">Blue</span>
                                </div>

                                <div class="col-lg-12">
                                    <span class="col-lg-4" style="padding: 1px">Plate No</span>
                                    <span id="jobDriverId" class="col-lg-8" style="padding: 1px">UV 123</span>
                                </div>

                                <div class="col-lg-12">
                                    <span class="col-lg-4" style="padding: 1px">Paging Board</span>
                                    <span id="jobCabId" class="col-lg-8" style="padding: 1px">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default col-lg-7 " style="padding: 1px;">
                            <div class="panel-body" style="padding: 1px">
                                <span class="col-lg-3" style="padding: 1px">Address</span>
                                <span id="jobAddress" class="col-lg-9" style="padding: 1px">8/2 , Viahara Road , Mount Lavania ,Colombo. Near the cargills</span>

                                <span class="col-lg-3" style="padding: 1px">Remark</span>
                                <span id="jobRemark" class="col-lg-9" style="padding: 1px">English Speaking Driver</span>

                                <span class="col-lg-3" style="padding: 1px">Destination</span>
                                <span id="jobDestination" class="col-lg-9" style="padding: 1px">Wellawatta</span>

                                <span class="col-lg-3" style="padding: 1px">Call Up</span>
                                <span id="jobDestination" class="col-lg-9" style="padding: 1px">200</span>

                                <span class="col-lg-3" style="padding: 1px">Specs</span>
                                <span id="jobSpecifications" class="col-lg-9" style="padding: 1px">VIA | VIH</span>

                            </div>
                        </div>


                        <div class="panel panel-default col-lg-7 " style="padding: 1px;">
                            <div class="panel-body" style="padding: 1px">
                                <span class="col-lg-3" style="padding: 1px">Book Time</span>
                                <span id="jobAddress" class="col-lg-9" style="padding: 1px">06:30 2014-11-01 </span>

                                <span class="col-lg-3" style="padding: 1px">Call Time</span>
                                <span id="jobRemark" class="col-lg-9" style="padding: 1px">05:30 2014-11-01 </span>

                                <span class="col-lg-3" style="padding: 1px">Dispatch</span>
                                <span id="jobDestination" class="col-lg-9" style="padding: 1px">30 mins</span>

                                <span class="col-lg-3" style="padding: 1px">Specs</span>
                                <span id="jobSpecifications" class="col-lg-9" style="padding: 1px">VIA | VIH</span>

                                <span class="col-lg-3" style="padding: 1px">Payment</span>
                                <span id="jobPayType" class="col-lg-9" style="padding: 1px">Cash</span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="margin-top: 5px ; padding: 1px">
                            <div class="col-lg-12" style="padding: 1px">
                                <div class="well well-sm" style="min-height: 0px"></div>
                            </div>

                            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default btn-sm">
                                        <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Update
                                    </button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default btn-sm">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Inquire
                                    </button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default btn-sm">
                                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Complaint
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
                </div>
            </div>



        </div>

        <div class="col-lg-12" style="margin-top: 10px" id="newBooking">

        </div>

        <div class="col-lg-8" style="margin-top: 10px" id="bookingHistory">

        </div>

        <div class="col-lg-4" style="margin-top: 10px" id="callHistory">

        </div>
    </div>
    <script>
        function operations(request, param1){
            if(request=="editCus"){
                editCustomerInfoEditView( url , param1 );
            }
            if(request == 'updateCusInfo'){
                updateCustomerInfoView( url );
            }
            if(request == 'getCustomer'){
                tp = $('#tpSearch').val();
                getCustomerInfoView( url , tp);
            }
            if(request == 'createCusInfo'){
                createCusInfo( url );
                getCustomerInfoView(url , tp , customerObj,bookingObj);
            }
            if(request == 'createBooking'){
                createBooking(url , tp);
                getCustomerInfoView(url , tp );
            }
            if(request == 'cancel'){
                getCancelConfirmationView(url ,param1);
            }
            if(request == 'confirmCancel'){
                alert(url + tp +param1);
                confirmCancel(url , tp ,param1);
            }
            if(request == 'denyCancel'){
                getCustomerInfoView(url, tp);
            }
            if(request == 'editBooking'){
                getEditBookingView(url,param1);
                //getCustomerInfoView(url, tp);
            }
            if(request == 'updateBooking'){
                updateBooking(url,param1);
                getCustomerInfoView(url , tp);
            }
            if(request == 'changeJobInfoView'){
                alert(param1);
                changeJobInfoViewByRefId(param1)
            }
            if(request == 'addUser'){
                addUserToCooperateProfile(url , tp );
            }
            if(request == 'fillAddressToBooking'){
                fillAddressToBooking(param1);
            }
            if(request == 'fillAddressToBookingFromHistory'){
                fillAddressToBookingFromHistory(param1);
            }
            if(request == 'addInquireCall'){
                addInquireCall(url ,param1);
                getCustomerInfoView(url , tp);
            }
            if(request == 'addComplaint'){
                addComplaint(url,param1);
                getCustomerInfoView(url , tp);
            }
            uiInit();
        }
    </script>


</body>

<script type="text/javascript" src="<?= base_url();?>assets/js/CroScripts/ViewModel.js"></script>
</html>