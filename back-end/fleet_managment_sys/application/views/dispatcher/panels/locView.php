<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        setBaseURL('<?= base_url().'index.php/' ?>');
    </script>
    <!-------------------------------- CSS Files------------------------------------>
<!--    <link rel="stylesheet" type="text/css" href="--><?//= base_url();?><!--assets/css/bootstrap.css">-->
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/webLibs/bootstrapvalidator-dist-0.5.2/dist/css/bootstrapValidator.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/webLibs/bootstrap-timepicker/css/bootstrap-timepicker.css">



    <!-------------------------------- JS Files------------------------------------>
<!--    <script type="text/javascript" src="--><?//= base_url();?><!--assets/js/jquery-1.10.2.js"></script>-->
<!--    <script type="text/javascript" src="--><?//= base_url();?><!--assets/js/bootstrap.js"></script>-->
    <script type="text/javascript" src="<?= base_url();?>assets/js/cro_operations.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/bootstrap-timepicker/js/bootstrap-timepicker.js" charset="UTF-8"></script>

    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/bootstrapvalidator-dist-0.5.2/dist/js/bootstrapValidator.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/knockout/knockout-3.2.0.js"></script>

    <style>
        input.locIdleInput{
            width:55%;
            display: inline;
        }
        input.locPobInput{
            width:60%;
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
<h2 style="text-align: center; margin-bottom: 0">Location Board</h2>

<div id="LocationContainer" style="overflow: auto; height: 100%">

        <div id="idleContainer" class="row" style="padding: 2%">

            <div class="panel panel-success">
                <div class="panel-heading text-center">
                    <span>Idle Cabs</span>
                </div>
                <div class="panel-body">

                    <!--First Column of Zones-->
                    <div id="zoneCol1Container" class="col-md-6">
                        <div class="table-responsive" style="width:100%; margin:0">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th  class="col-md-2">Zone</th>
                                    <th  class="col-md-3">Add Cab</th>
                                    <th  class="col-md-5">Available Cabs</th>

                                </tr>
                                </thead>
                                <tbody data-bind="foreach:ZonesColumn1">
                                <tr>
                                    <td class="col-md-2" data-bind="text:name" ></td>
                                    <td class="col-md-3">
                                        <input data-bind="attr:{id:id}, value:idle.driverId" class="form-control driverId locIdleInput" type="text" placeholder="Driver Id">
                                        <button data-bind="click:$root.addIdleCab" class="form-control cabAdd">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                    </td>
                                    <td class="col-md-5">
                                        <ul style="display: inline" class="cabs" data-bind="foreach:idle.cabs">
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
                                                                            <td><span>State</span></td>
                                                                            <td><span data-bind="text:state"></span></td>
                                                                        </tr>
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

                                                                    <div class="row" style="float:right; margin:0">
                                                                        <button class="btn btn-success cabManipulate" data-bind="click:$root.dispatchCab.bind($data , $parent )">Dispatch</button>
                                                                    </div>

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
                                    <th  class="col-md-3">Add Cab</th>
                                    <th  class="col-md-5">Available Cabs</th>

                                </tr>
                                </thead>
                                <tbody data-bind="foreach:ZonesColumn2">
                                <tr>
                                    <td class="col-md-2" data-bind="text:name" ></td>
                                    <td class="col-md-3">
                                        <input data-bind="attr:{id:id}, value:idle.driverId" class="form-control driverId locIdleInput" type="text" placeholder="Driver Id" >
                                        <button data-bind="click:$root.addIdleCab" class="form-control cabAdd">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                    </td>
                                    <td class="col-md-5">
                                        <ul style="display: inline" class="cabs" data-bind="foreach:idle.cabs">
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
                                                                            <td><span>State</span></td>
                                                                            <td><span data-bind="text:state"></span></td>
                                                                        </tr>
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

                                                                    <div class="row" style="float:right; margin:0">
                                                                        <button class="btn btn-success cabManipulate" data-bind="click:$root.dispatchCab.bind($data , $parent )">Dispatch</button>
                                                                    </div>

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

        <div id="pobContainer" class="row" style="padding: 2%">

            <div class="panel panel-warning">
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
                                    <th  class="col-md-2">Destination Zone</th>
                                    <th  class="col-md-3">Add Cab</th>
                                    <th  class="col-md-5">Available Cabs</th>

                                </tr>
                                </thead>
                                <tbody data-bind="foreach:ZonesColumn1">
                                <tr>
                                    <td class="col-md-2" data-bind="text:name" ></td>
                                    <td class="col-md-3">
                                        <div class="input-append bootstrap-timepicker">
                                            <input data-bind="attr:{id:id}, value:pob.cabEta" class="form-control cabEta locPobInput timePicker input-small" type="text" placeholder="ETA" >
                                            <span class="add-on"><i class="glyphicon glyphicon-time"></i></span>
                                        </div>

                                        <input data-bind="attr:{id:id}, value:pob.driverId" class="form-control driverId locPobInput" type="text" placeholder="Driver Id">
                                        <button data-bind="click:$root.addPobCab" class="form-control cabAdd">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                    </td>
                                    <td class="col-md-5">
                                        <ul style="display: inline" class="cabs" data-bind="foreach:pob.cabs">
                                            <li style="display: inline">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-warning dropdown-toggle cabView" data-toggle="dropdown">
                                                        <span data-bind="text:vehicleType"></span>
                                                        <span data-bind="text:id">2342 &nbsp;</span>
                                                        <span class="caret"></span>
                                                    </button>

                                                    <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                                        <div class="panel panel-warning">
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
                                                                            <td><span>State</span></td>
                                                                            <td><span data-bind="text:state"></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><span>ETA</span></td>
                                                                            <td><span data-bind="text:eta"></span></td>
                                                                        </tr>
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

                                                                    <div class="row" style="float:right; margin:0">
                                                                        <button class="btn btn-warning cabManipulate" data-bind="click:$root.setToIdleFromPob.bind($data , $parent )">Set Idle</button>
                                                                        <button class="btn btn-warning cabManipulate" data-bind="click:$root.removeCabFromPob.bind($data , $parent )">Remove</button>
                                                                    </div>

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
                                    <th  class="col-md-3">Add Cab</th>
                                    <th  class="col-md-5">Available Cabs</th>

                                </tr>
                                </thead>
                                <tbody data-bind="foreach:ZonesColumn2">
                                <tr>
                                    <td class="col-md-2" data-bind="text:name" ></td>
                                    <td class="col-md-3">
                                        <div class="input-append bootstrap-timepicker">
                                            <input data-bind="attr:{id:id}, value:pob.cabEta" class="form-control cabEta locPobInput timePicker input-small" type="text" placeholder="ETA" >
                                            <span class="add-on"><i class="glyphicon glyphicon-time"></i></span>
                                        </div>
                                        <input data-bind="attr:{id:id}, value:pob.driverId" class="form-control cabDriverId locPobInput" type="text" placeholder="Driver id">
                                        <button data-bind="click:$root.addPobCab" class="form-control cabAdd">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                    </td>
                                    <td class="col-md-5">
                                        <ul style="display: inline" class="cabs" data-bind="foreach:pob.cabs">
                                            <li style="display: inline">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-warning dropdown-toggle cabView" data-toggle="dropdown">
                                                        <span data-bind="text:vehicleType"></span>
                                                        <span data-bind="text:id">2342 &nbsp;</span>
                                                        <span class="caret"></span>
                                                    </button>

                                                    <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                                        <div class="panel panel-warning">
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
                                                                            <td><span>State</span></td>
                                                                            <td><span data-bind="text:state"></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><span>ETA</span></td>
                                                                            <td><span data-bind="text:eta"></span></td>
                                                                        </tr>
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

                                                                    <div class="row" style="float:right; margin:0">
                                                                        <button class="btn btn-warning cabManipulate" data-bind="click:$root.setToIdleFromPob.bind($data , $parent )">Set Idle</button>
                                                                        <button class="btn btn-warning cabManipulate" data-bind="click:$root.removeCabFromPob.bind($data , $parent )">Remove</button>
                                                                    </div>

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

        <div id="pendingInactiveContainer" class="row" style="padding: 2%">

            <div class="col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading text-center">
                        <span>Pending Container</span>
                    </div>
                    <div class="panel-body" style="min-height: 65px">
                        <ul style="display: inline" class="cabs" data-bind="foreach:pendingCabs">
                            <li style="display: inline">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger dropdown-toggle cabView" data-toggle="dropdown" style="min-width: 90px">
                                        <span data-bind="text:vehicleType"></span>
                                        <span data-bind="text:id">2342 &nbsp;</span>
                                        <span class="caret"></span>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                        <div class="panel panel-danger">
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
                                                            <td><span>State</span></td>
                                                            <td><span data-bind="text:state"></span></td>
                                                        </tr>
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

                                                    <div class="row" style="float:right; margin:0">
                                                        <button class="btn btn-danger cabManipulate" data-bind="click:$root.removeCabFromPending.bind($data , $parent )">Remove Cab</button>
                                                    </div>

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
                        <span>Inactive Container</span>
                    </div>
                    <div class="panel-body" style="min-height: 65px">
                        <ul style="display: inline" class="cabs" data-bind="foreach:inactiveCabs">
                            <li style="display: inline">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle cabView" data-toggle="dropdown" style="min-width: 90px">
                                        <span data-bind="text:vehicleType"></span>
                                        <span data-bind="text:id">2342 &nbsp;</span>
                                        <span class="caret"></span>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                        <div class="panel panel-default">
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
                                                            <td><span>State</span></td>
                                                            <td><span data-bind="text:state"></span></td>
                                                        </tr>
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

                                                    <div class="row" style="float:right; margin:0">
                                                        <!--<button class="btn btn-default" data-bind="click:$root.removeCabFromPending.bind($data , $parent )">Remove Cab</button>-->
                                                    </div>

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

        <div style="height: 80%">

        </div>

</div>
<script type="text/javascript" src="<?= base_url();?>assets/js/LocationBoardScripts/ViewModel.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.timePicker').timepicker({
        defaultTime: false
    });
</script>

</body>
</html>