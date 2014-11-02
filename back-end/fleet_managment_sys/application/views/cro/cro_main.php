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
            <li class="active"><a href="#" onclick="getAllCabs()">CRO</a></li>
            <li><a href="<?= site_url('cro_controller/test')?>" >My Bookings</a></li>
        </ul>

        <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Mobile / LandLine" id="tpSearch">
            </div>
            <button type="button" class="btn btn-default" onclick="operations('getCustomer')">Submit</button>
        </form>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</div>

<div class="container-fluid">
    <div class="row" style="background: #d7ddeb">
        <div class="col-lg-12" style="margin-top: 10px">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Job Information</h5>
                </div>
                <div class="panel-body" >

                    <div class="col-lg-12" id="jobInfo" >

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12" style="margin-top: 10px">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Customer Information</h3>
                </div>
                <div class="panel-body" id="customerInformation">



                </div>
            </div>
        </div>


        <div class="col-lg-12" style="margin-top: 10px">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">New Order</h3>
                </div>
                <div class="panel-body" id="newBooking">

                </div>
            </div>
        </div>

        <div class="col-lg-12" style="margin-top: 10px">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Booking History</h3>
                </div>
                <div class="panel-body" id="newBooking">

                </div>
            </div>
        </div>
</div>

    <script>
        $("#tpSearch").keyup(function(event){
            var url = '<?= site_url(); ?>';
            var tp = $("#tpSearch").val();
            getSimilarTpNumbers(url,tp)
        });
    </script>


    <script>
        function operations(request, param1){
            if(request=="editCus"){
                console.log(param1);
                editCustomerInfoEditView( url , param1 );

            }

            if(request == 'updateCusInfo'){
                updateCustomerInfoView( url );
            }
            if(request == 'getCustomer'){

                tp      = document.getElementById("tpSearch").value;
                var view =getCustomerInfoView( url , tp );

                uiInit();

//                var arr = jobInfo.getElementsByTagName('script');
//                for (var n = 0; n < arr.length; n++) {
//                    eval(arr[n].innerHTML)//run script inside div
//                }

            }
            if(request == 'createCusInfo'){
                $('#newCustomer').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    excluded:[]
                    ,
                    fields: {
                    }

                })
                .on('success.form.bv', function(e) {
                    // Prevent form submission
                    e.preventDefault();
                    createCusInfo( url );
                });

                createCusInfo( url );
                getCustomerInfoView(url , tp , customerObj,bookingObj);
                uiInit();


            }
            if(request == 'createBooking'){
                // Validate Form Before Creating Booking


                $('#newBookingForm').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    excluded:[]
                    ,
                    fields: {
                        paymentType: {
                            message: 'The field is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Payment Type Not Selected'
                                }
                            }
                        },

                        vehicleType: {
                            message: 'The field is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Vehicle Type Not Selected'
                                }
                            }
                        },
                        bDate: {
                            message: 'The field is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Booking Date Not Selected'
                                }
                            }
                        },
                        bTime:{
                            message: 'The field is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Booking Time Not Selected'
                                }
                            }
                        },

                        dispatchBefore:{
                            message: 'The field is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Dispatch Before time cannot be empty'
                                },
                                greaterThan: {
                                    message: 'Dispatch before time should be greater than or equal to  30',
                                    value : 30,
                                    inclusive:true

                                }
                            }
                        }
                    }

                })
                .on('success.form.bv', function(e) {
                    // Prevent form submission
                    e.preventDefault();
                    createBooking(url , tp);
                    getCustomerInfoView(url , tp , customerObj,bookingObj);
                    uiInit();


                });

                createBooking(url , tp);
                getCustomerInfoView(url , tp , customerObj,bookingObj);
            }
            if(request == 'cancel'){
                getCancelConfirmationView(url , tp , param1)
            }
            if(request == 'confirmCancel'){
                confirmCancel(url , tp ,param1);
            }
            if(request == 'denyCancel'){
                getCustomerInfoView(url, tp,customerObj,bookingObj)
            }
            if(request == 'editBooking'){
                getEditBookingView(url,param1);
                uiInit();
            }
            if(request == 'updateBooking'){
                updateBooking(url,param1);
                getCustomerInfoView(url , tp,customerObj,bookingObj);
            }
        }
    </script>


</body>
</html>