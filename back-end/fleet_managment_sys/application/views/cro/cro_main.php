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
    <style>
        .nts-label{

            /*font-size: 75%;*/
            padding: .2em 16px .3em;
            margin: 0 12px;
            font-size: 15px;
            font-weight: bold;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
            background-color: #777;
        }

        .nts-label-value{
            display: inline;
        }


        .nts-label-small{

            /*font-size: 75%;*/
            padding: 0.4em 3px .5em;
            margin: 0 0px;
            font-size: 12px;
            font-weight: bold;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
            background-color: #777;
        }

        .nts-label-value-small{
            display: inline;
        }




    </style>
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
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody data-bind="foreach:currentNumbers">
                                <tr>
                                    <td data-bind="text:readableTimeStamp" style="padding: 13px; text-align: right;"><span>2014/10/23</span></td>
                                    <td data-bind="text:number" style="padding: 13px ; text-align: right;"><span>0772866596</span></td>
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
            <li><a href="<?= site_url('cro_controller/refresh')?>" >Refresh</a>
            <li><a href="<?= site_url('cro_controller/getCabHeaderView')?>" >Cabs</a>
            <li><a href="<?= site_url('cro_controller/getAllPackagesView')?>" >Packages</a>
<!--            <li><a href="" onclick="forCro()">Packages</a>-->

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

        <div class="col-lg-12" style="margin-top: 10px">
            <!--div class="panel panel-default">
                <div class="panel-body" style="padding: 3px"-->
                    <div class="col-lg-6" style="margin-top: 10px; padding: 2px" id="customerInformation">

                    </div>

                    <div class="col-lg-6" style="margin-top: 10px; padding: 2px" id="jobInfo" >

                    </div>

                <!--/div>
            </div-->
        </div>



        <div class="col-lg-12" style="margin-top: 10px"  id="newBooking">
            <div class="col-lg-offset-3 col-lg-7" style="margin-top: 10%">
                <img style="width: 80%" src="<?= base_url() ?>assets/img/hao-logo-small.png">
            </div>
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
            ///////////////////TODO: Implement To Identify a called customer
            if(request == 'getCalledCustomer'){
                tp = $('#tpSearch').val();
                getCustomerInfoView( url , tp,param1);
            }
            ///////////////////
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
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h2 class="modal-title" id="myModalLabel">Confirm Booking Details of Booking #123123</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div >


                            <div style="margin:4px 30px 20px">
                                    <legend style="margin:0;; border-bottom: transparent">Location Details</legend>

                                    <div class="list-group-item" style="overflow:auto; border-top-left-radius: 4px; border-top-right-radius: 4px">
                                        <div class="col-md-3" style="padding: 0 "><div class="nts-label ">No</div></div>
                                        <div class="col-md-9" style="padding: 0 10px"><span id="no" class="nts-label-value modalConfirm">54/2 54/2 54/2</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-3" style="padding: 0"><div class="nts-label " >Road</div></div>
                                        <div class="col-md-9" style="padding: 0 10px"><span id="road" class="nts-label-value  modalConfirm">Awesome Road Awesome Road Awesome Road Awesome Road Awesome Road</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-3" style="padding: 0"><div class="nts-label  ">City</div></div>
                                        <div class="col-md-9" style="padding: 0 10px"><span id="city" class="nts-label-value  modalConfirm">Colombo Colombo</span></div>
                                    </div>

                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-3" style="padding: 0"><div class="nts-label  " >Town</div></div>
                                        <div class="col-md-9" style="padding: 0 10px"><span id="town"  class="nts-label-value  modalConfirm">Town X</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-3" style="padding: 0"><div class="nts-label " >Land Mark</div></div>
                                        <div class="col-md-9" style="padding: 0 10px"><span id="landMark" class="nts-label-value  modalConfirm">Clocktower Clocktower  Clocktower Clocktower</span></div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div style="margin:4px 30px 20px">
                                <div class="col-md-6" style="padding: 0px 5px 0 0px;" >
                                    <legend style="margin:0;; border-bottom: transparent">Dispatch Details</legend>

                                    <div class="list-group-item" style="overflow:auto; border-top-left-radius: 4px; border-top-right-radius: 4px">
                                        <div class="col-md-5" style="padding: 0 "><div  id="landMark" class="nts-label-small ">Remark</div></div>
                                        <div id="remark" class="col-md-7" style="padding: 0 10px"><span class="nts-label-value modalConfirm">Alert be on time!</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-5" style="padding: 0"><div class="nts-label-small  " >Dispatch Before</div></div>
                                        <div  id="dispatchB4" class="col-md-7" style="padding: 0 10px"><span class="nts-label-value modalConfirm">30</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-5" style="padding: 0"><div class="nts-label-small ">Call Up</div></div>
                                        <div  id="callUpPrice" class="col-md-7" style="padding: 0 10px"><span class="nts-label-value modalConfirm">-</span></div>
                                    </div>

                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-5" style="padding: 0"><div class="nts-label-small " >Paging Board</div></div>
                                        <div  id="pagingBoard" class="col-md-7" style="padding: 0 10px"><span class="nts-label-value modalConfirm">-</span></div>
                                    </div>

                                </div>

                                <div class="col-md-6" style="padding: 0px 0px 0 5px">
                                    <legend style="margin:0; border-bottom: transparent">Booking Details</legend>

                                    <div class="list-group-item" style="overflow:auto; border-top-left-radius: 4px; border-top-right-radius: 4px">
                                        <div class="col-md-5" style="padding: 0 "><div class="nts-label-small">Vehicle Type</div></div>
                                        <div class="col-md-7" style="padding: 0 10px"><span id ="vehicleType"  class="nts-label-value modalConfirm">Nano</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-5" style="padding: 0"><div class="nts-label-small" >Payment Type</div></div>
                                        <div class="col-md-7" style="padding: 0 10px"><span id ="payentType" class="nts-label-value modalConfirm">Cash</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-5" style="padding: 0"><div class="nts-label-small ">Booking Time</div></div>
                                        <div class="col-md-7" style="padding: 0 10px"><span  id ="bTime" class="nts-label-value modalConfirm">03:56</span></div>
                                    </div>

                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-5" style="padding: 0"><div class="nts-label-small " >Booking Date</div></div>
                                        <div class="col-md-7" style="padding: 0 10px"><span id ="bDate" class="nts-label-value modalConfirm">2014-11-29</span></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div style="margin:4px 30px 20px">
                            <div style="padding: 0px 5px 0 0px;" >
                                <legend style="margin:0;; border-bottom: transparent">Booking Requirements</legend>

                                <div class="list-group-item" style="overflow:auto; border-top-left-radius: 4px; border-top-right-radius: 4px">
                                    <div class="col-md-7" style="padding: 0 10px"><span class="nts-label-value modalConfirm">VIP | Tinted</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Create Booking</button>
                </div>
            </div>
        </div>
    </div>

</body>

<script type="text/javascript" src="<?= base_url();?>assets/js/CroScripts/ViewModel.js"></script>
</html>

