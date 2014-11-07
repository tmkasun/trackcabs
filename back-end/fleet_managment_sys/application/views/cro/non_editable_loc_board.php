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
    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/knockout/knockout-3.2.0.js"></script>

    <script src="<?= base_url() ?>assets/js/application_options.js"></script>

    <script>
        setBaseURL('<?= base_url().'index.php/' ?>');
    </script>

    <style>



        input.locInput{
            width:65%;
            display: inline;
        }

        ul.cabs{
            list-style: none;
            padding: 0;
            margin: 0;
            list-style-type: none;
        }

        li.cab{
            display: inline;
        }

        .cabView{
            width: auto;
            display: inline;
            margin-bottom: 2%;
            margin-right: 2%;

        }
        button.cabAdd{
            width: auto;
            display: inline;
            margin-bottom: 5px;

        }

        .dropdown-menu2{

            left:-217%;
        }



        .dropdown-menu1{

            left:-45%;
        }




    </style>

</head>
<body>

<div id="navBarField">
    <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Hao Cabs</a>
        </div>

        <ul class="nav navbar-nav">
            <li><a href="<?= site_url('cro_controller')?>">CRO</a></li>

            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Mobile / LandLine" id="tpSearch" autofocus>
                </div>
                <input type="submit" class="btn btn-default" onclick="operations('getCustomer');return false" onsubmit="operations('getCustomer');return false" value="Submit" />
            </form>


            <li><a href="<?= site_url('cro_controller/loadMyBookingsView')?>" >My Bookings</a></li>
            <li><a href="<?= site_url('cro_controller/loadMapView')?>" >Map</a></li>
            <li class="active"><a href="<?= site_url('cro_controller/loadLocationBoardView')?>" >Location Board</a></li>
            <li><a href="<?= site_url('cro_controller/loadPOBBoardView')?>" >POB Board</a></li>
            <li><a href="<?= site_url('cro_controller/refresh')?>" >Refresh</a></li>
        </ul>



        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Link</a></li>
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


<div id="LocationContainer" style="overflow: auto; height: 100%">

<div id="liveContainer" class="row" style="padding: 2%">

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <span>Live Cabs</span>
        </div>
        <div class="panel-body">

            <!--First Column of Zones-->
            <div id="zoneCol1Container" class="col-md-6">
                <div class="table-responsive" style="width:100%; margin:0">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th  class="col-md-2">Zone</th>
                            <th  class="col-md-5">Avail. Cabs</th>

                        </tr>
                        </thead>
                        <tbody data-bind="foreach:ZonesColumn1">
                        <tr>
                            <td class="col-md-2" data-bind="text:name" ></td>
                            <td class="col-md-8">
                                <ul style="display: inline" class="cabs" data-bind="foreach:live.cabs">
                                    <li style="display: inline">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success dropdown-toggle cabView" data-toggle="dropdown" style="min-width: 90px">
                                                <span data-bind="text:vehicleType"></span>
                                                <span data-bind="text:id">2342 &nbsp;</span>
                                                <span class="caret"></span>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                                <div class="panel panel-success">
                                                    <div class="panel-heading">
                                                        <h2 class="panel-title" data-bind="text:vehicleType + ' '+ id + ' Info' "></h2>
                                                    </div>

                                                    <div class="panel-body" style="padding: 3%">
                                                        <div style="margin:0">
                                                            <table class="table table-bordered" style="margin-bottom:2%">
                                                                <thead>
                                                                <tr>
                                                                    <th style="width:30%">Attribute</th>
                                                                    <th>Value</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td><span>Vehicle Type</span></td>
                                                                    <td><span data-bind="text:vehicleType"></span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><span>Model</span></td>
                                                                    <td><span data-bind="text:attributes.model"></span></td>
                                                                </tr>

                                                                <!--tr>
                                                                    <td><span>Is Tinted?</span></td>
                                                                    <td><span data-bind="text:attributes.isTinted"></span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><span>Is Marked?</span></td>
                                                                    <td><span data-bind="text:attributes.isMarked"></span></td>
                                                                </tr-->
                                                                <tr>
                                                                    <td><span>Vehicle Colour</span></td>
                                                                    <td><span data-bind="text:attributes.vehicleColor"></span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><span>Information</span></td>
                                                                    <td><span data-bind="text:attributes.info"></span></td>
                                                                </tr>



                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!--Second Column of Zones-->
            <div id="zoneCol2Container" class="col-md-6">
                <div class="table-responsive" style="width:100%; margin:0">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th  class="col-md-2">Zone</th>
                            <th  class="col-md-5">Avail. Cabs</th>

                        </tr>
                        </thead>
                        <tbody data-bind="foreach:ZonesColumn2">
                        <tr>
                            <td class="col-md-2" data-bind="text:name" ></td>
                            <td class="col-md-8">
                                <ul style="display: inline" class="cabs" data-bind="foreach:live.cabs">
                                    <li style="display: inline">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success dropdown-toggle cabView" data-toggle="dropdown">
                                                <span data-bind="text:vehicleType"></span>
                                                <span data-bind="text:id">2342 &nbsp;</span>
                                                <span class="caret"></span>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                                <div class="panel panel-success">
                                                    <div class="panel-heading">
                                                        <h2 class="panel-title" data-bind="text:vehicleType + ' '+ id + ' Info' "></h2>
                                                    </div>

                                                    <div class="panel-body" style="padding: 3%">
                                                        <div style="margin:0">
                                                            <table class="table table-bordered" style="margin-bottom:2%">
                                                                <thead>
                                                                <tr>
                                                                    <th style="width:30%">Attribute</th>
                                                                    <th>Value</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td><span>Vehicle Type</span></td>
                                                                    <td><span data-bind="text:vehicleType"></span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><span>Model</span></td>
                                                                    <td><span data-bind="text:attributes.model"></span></td>
                                                                </tr>

                                                                <!--tr>
                                                                    <td><span>Is Tinted?</span></td>
                                                                    <td><span data-bind="text:attributes.isTinted"></span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><span>Is Marked?</span></td>
                                                                    <td><span data-bind="text:attributes.isMarked"></span></td>
                                                                </tr-->

                                                                <tr>
                                                                    <td><span>Information</span></td>
                                                                    <td><span data-bind="text:attributes.info"></span></td>
                                                                </tr>


                                                                </tbody>
                                                            </table>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>

<div id="pendingUnknownContainer" class="row" style="padding: 2%">

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <span>Pending Container</span>
            </div>
            <div class="panel-body" style="min-height: 65px">
                <ul style="display: inline" class="cabs" data-bind="foreach:pendingCabs">
                    <li style="display: inline">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle cabView" data-toggle="dropdown" style="min-width: 90px">
                                <span data-bind="text:vehicleType"></span>
                                <span data-bind="text:id">2342 &nbsp;</span>
                                <span class="caret"></span>
                            </button>

                            <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h2 class="panel-title" data-bind="text:vehicleType + ' '+ id + ' Info' "></h2>
                                    </div>

                                    <div class="panel-body" style="padding: 3%">
                                        <div style="margin:0">
                                            <table class="table table-bordered" style="margin-bottom:2%">
                                                <thead>
                                                <tr>
                                                    <th style="width:30%">Attribute</th>
                                                    <th>Value</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><span>Vehicle Type</span></td>
                                                    <td><span data-bind="text:vehicleType"></span></td>
                                                </tr>

                                                <tr>
                                                    <td><span>Model</span></td>
                                                    <td><span data-bind="text:attributes.model"></span></td>
                                                </tr>

                                                <!--tr>
                                                    <td><span>Is Tinted?</span></td>
                                                    <td><span data-bind="text:attributes.isTinted"></span></td>
                                                </tr>

                                                <tr>
                                                    <td><span>Is Marked?</span></td>
                                                    <td><span data-bind="text:attributes.isMarked"></span></td>
                                                </tr-->
                                                <tr>
                                                    <td><span>Vehicle Colour</span></td>
                                                    <td><span data-bind="text:attributes.vehicleColor"></span></td>
                                                </tr>

                                                <tr>
                                                    <td><span>Information</span></td>
                                                    <td><span data-bind="text:attributes.info"></span></td>
                                                </tr>



                                                </tbody>
                                            </table>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <span>Unknown Container</span>
            </div>
            <div class="panel-body" style="min-height: 65px">
                <ul style="display: inline" class="cabs" data-bind="foreach:unknownCabs">
                    <li style="display: inline">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle cabView" data-toggle="dropdown" style="min-width: 90px">
                                <span data-bind="text:vehicleType"></span>
                                <span data-bind="text:id">2342 &nbsp;</span>
                                <span class="caret"></span>
                            </button>

                            <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h2 class="panel-title" data-bind="text:vehicleType + ' '+ id + ' Info' "></h2>
                                    </div>

                                    <div class="panel-body" style="padding: 3%">
                                        <div style="margin:0">
                                            <table class="table table-bordered" style="margin-bottom:2%">
                                                <thead>
                                                <tr>
                                                    <th style="width:30%">Attribute</th>
                                                    <th>Value</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><span>Vehicle Type</span></td>
                                                    <td><span data-bind="text:vehicleType"></span></td>
                                                </tr>

                                                <tr>
                                                    <td><span>Model</span></td>
                                                    <td><span data-bind="text:attributes.model"></span></td>
                                                </tr>

                                                <!--tr>
                                                    <td><span>Is Tinted?</span></td>
                                                    <td><span data-bind="text:attributes.isTinted"></span></td>
                                                </tr>

                                                <tr>
                                                    <td><span>Is Marked?</span></td>
                                                    <td><span data-bind="text:attributes.isMarked"></span></td>
                                                </tr-->
                                                <tr>
                                                    <td><span>Vehicle Colour</span></td>
                                                    <td><span data-bind="text:attributes.vehicleColor"></span></td>
                                                </tr>

                                                <tr>
                                                    <td><span>Information</span></td>
                                                    <td><span data-bind="text:attributes.info"></span></td>
                                                </tr>



                                                </tbody>
                                            </table>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>

<div id="pobContainer" class="row" style="padding: 2%">

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <span>POB Board</span>
        </div>
        <div class="panel-body">

            <!--First Column of Zones-->
            <div id="zoneCol1Container" class="col-md-6">
                <div class="table-responsive" style="width:100%; margin:0">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th  class="col-md-2">Zone</th>
                            <th  class="col-md-5">Avail. Cabs</th>

                        </tr>
                        </thead>
                        <tbody data-bind="foreach:ZonesColumn1">
                        <tr>
                            <td class="col-md-2" data-bind="text:name" ></td>
                            <td class="col-md-8">
                                <ul style="display: inline" class="cabs" data-bind="foreach:pob.cabs">
                                    <li style="display: inline">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success dropdown-toggle cabView" data-toggle="dropdown">
                                                <span data-bind="text:vehicleType"></span>
                                                <span data-bind="text:id">2342 &nbsp;</span>
                                                <span class="caret"></span>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                                <div class="panel panel-success">
                                                    <div class="panel-heading">
                                                        <h2 class="panel-title" data-bind="text:vehicleType + ' '+ id + ' Info' "></h2>
                                                    </div>

                                                    <div class="panel-body" style="padding: 3%">
                                                        <div style="margin:0">
                                                            <table class="table table-bordered" style="margin-bottom:2%">
                                                                <thead>
                                                                <tr>
                                                                    <th style="width:30%">Attribute</th>
                                                                    <th>Value</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td><span>Vehicle Type</span></td>
                                                                    <td><span data-bind="text:vehicleType"></span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><span>Model</span></td>
                                                                    <td><span data-bind="text:attributes.model"></span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><span>Colour</span></td>
                                                                    <td><span data-bind="text:attributes.vehicleColor"></span></td>
                                                                </tr>

                                                                <!--tr>
                                                                    <td><span>Is Tinted?</span></td>
                                                                    <td><span data-bind="text:attributes.isTinted"></span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><span>Is Marked?</span></td>
                                                                    <td><span data-bind="text:attributes.isMarked"></span></td>
                                                                </tr-->
                                                                <tr>
                                                                    <td><span>Information</span></td>
                                                                    <td><span data-bind="text:attributes.info"></span></td>
                                                                </tr>



                                                                </tbody>
                                                            </table>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!--Second Column of Zones-->
            <div id="zoneCol2Container" class="col-md-6">
                <div class="table-responsive" style="width:100%; margin:0">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th  class="col-md-2">Zone</th>
                            <th  class="col-md-5">Avail. Cabs</th>

                        </tr>
                        </thead>
                        <tbody data-bind="foreach:ZonesColumn2">
                        <tr>
                            <td class="col-md-2" data-bind="text:name" ></td>

                            <td class="col-md-8">
                                <ul style="display: inline" class="cabs" data-bind="foreach:pob.cabs">
                                    <li style="display: inline">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success dropdown-toggle cabView" data-toggle="dropdown">
                                                <span data-bind="text:vehicleType"></span>
                                                <span data-bind="text:id">2342 &nbsp;</span>
                                                <span class="caret"></span>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                                <div class="panel panel-success">
                                                    <div class="panel-heading">
                                                        <h2 class="panel-title" data-bind="text:vehicleType + ' '+ id + ' Info' "></h2>
                                                    </div>

                                                    <div class="panel-body" style="padding: 3%">
                                                        <div style="margin:0">
                                                            <table class="table table-bordered" style="margin-bottom:2%">
                                                                <thead>
                                                                <tr>
                                                                    <th style="width:30%">Attribute</th>
                                                                    <th>Value</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td><span>Vehicle Type</span></td>
                                                                    <td><span data-bind="text:vehicleType"></span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><span>Model</span></td>
                                                                    <td><span data-bind="text:attributes.model"></span></td>
                                                                </tr>

                                                                <!--tr>
                                                                    <td><span>Is Tinted?</span></td>
                                                                    <td><span data-bind="text:attributes.isTinted"></span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><span>Is Marked?</span></td>
                                                                    <td><span data-bind="text:attributes.isMarked"></span></td>
                                                                </tr-->

                                                                <tr>
                                                                    <td><span>Information</span></td>
                                                                    <td><span data-bind="text:attributes.info"></span></td>
                                                                </tr>


                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>

<div style="height: 45%">

</div>

</div>
<script type="text/javascript" src="<?= base_url();?>assets/js/LocationBoardScripts/ViewModel.js" charset="UTF-8"></script>


</body>
</html>