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
            <div class="col-lg-offset-3 col-lg-7" style="margin-top: 10%">
                <!--img style="width: 80%" src="<?= base_url() ?>assets/img/hao-logo-small.png"-->
            </div>
        </div>

        <div class="col-lg-6" style="margin-top: 10px;" id="jobInfo" >
            
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