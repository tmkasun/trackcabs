<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-------------------------------- CSS Files------------------------------------>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap-datetimepicker.css">
    <!-------------------------------- JS Files------------------------------------>
    <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/cro_operations.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>

        <script>
        var docs_per_page= 100 ;
        var page = 1 ;
        var obj = null;
        var tp;
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
                <div class="panel-body" id="">

                    <div class="col-lg-5" >
                        <div class="col-lg-12" id="mainSearch">
                            <div class="input-group">

                                    <input type="text" class="form-control" placeholder="Mobile / LandLine" id="tpSearch">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" onclick="operations('getCustomer')">
                                                <span class="glyphicon glyphicon-search"></span> Search
                                            </button>
                                        </span>
                            </div>
                            <hr>

                        </div>
                    </div>

                    <div class="col-lg-7" id="jobInfo" style="border-left: 2px solid #a6a6a6" >

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
            var url = '<?= site_url(); ?>';
            if(request=="editCus"){
                editCustomerInfoEditView( url , param1 );
            }

            if(request == 'updateCusInfo'){
                updateCustomerInfoView( url );
            }
            if(request == 'getCustomer'){
                tp      = document.getElementById("tpSearch").value;
                getCustomerInfoView( url , tp );
            }
            if(request == 'createCusInfo'){
                createCusInfo( url );
            }
            if(request == 'createBooking'){
                createBooking(url , tp)
            }
            if(request == 'cancel'){
                getCancelConfirmationView(url , tp , param1)
            }
            if(request == 'confirmCancel'){
                confirmCancel(url , tp ,param1);
            }
            if(request == 'denyCancel'){
                //param2 = refId
                getCustomerInfoView(url, tp)
            }
            if(request == 'editBooking'){
                getEditBookingView(url,param1)
            }
            if(request == 'updateBooking'){
                alert('obj id is '+param1);
                updateBooking(url,param1)
            }
        }
    </script>





<script>
    $(document).ready(function(){
            //$("#test").hide();

        $("#show").click(function(){
            $("#test").collapse();
        });
    });
</script>


</body>
</html>