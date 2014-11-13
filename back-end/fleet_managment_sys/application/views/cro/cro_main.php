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
            <li class="active"><a href="<?= site_url('cro_controller')?>">CRO</a></li>

            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Mobile / LandLine" id="tpSearch" autofocus>
                </div>
                <input type="submit" class="btn btn-default" onclick="operations('getCustomer');return false" onsubmit="operations('getCustomer');return false" value="Submit" />
            </form>


            <li><a href="<?= site_url('cro_controller/loadMyBookingsView')?>" >My Bookings</a></li>
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
        <div class="col-lg-12" style="margin-top: 10px;" id="jobInfo" >
            <div class="col-lg-offset-3 col-lg-7" style="margin-top: 10%">
                <img style="width: 80%" src="<?= base_url() ?>assets/img/hao-logo-small.png">
            </div>
        </div>

        <div class="col-lg-12" style="margin-top: 10px" id="customerInformation">

        </div>


        <div class="col-lg-12" style="margin-top: 10px" id="newBooking">

        </div>

        <div class="col-lg-12" style="margin-top: 10px" id="bookingHistory">

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
                tp      = document.getElementById("tpSearch").value;
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
                confirmCancel(url , tp ,param1);
            }
            if(request == 'denyCancel'){
                getCustomerInfoView(url, tp);
            }
            if(request == 'editBooking'){
                getEditBookingView(url,param1);
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
            uiInit();
        }
    </script>


</body>
</html>