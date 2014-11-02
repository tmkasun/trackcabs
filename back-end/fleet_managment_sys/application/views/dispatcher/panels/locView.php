<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-------------------------------- CSS Files------------------------------------>
<!--    <link rel="stylesheet" type="text/css" href="--><?//= base_url();?><!--assets/css/bootstrap.css">-->
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/webLibs/bootstrapvalidator-dist-0.5.2/dist/css/bootstrapValidator.css">


    <!-------------------------------- JS Files------------------------------------>
<!--    <script type="text/javascript" src="--><?//= base_url();?><!--assets/js/jquery-1.10.2.js"></script>-->
<!--    <script type="text/javascript" src="--><?//= base_url();?><!--assets/js/bootstrap.js"></script>-->
    <script type="text/javascript" src="<?= base_url();?>assets/js/cro_operations.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>

    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/bootstrapvalidator-dist-0.5.2/dist/js/bootstrapValidator.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/knockout/knockout-3.2.0.js"></script>
    <style>
        input.cabInput{
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
<h2 style="text-align: center; margin-bottom: 1%">Location Board</h2>
<!--div class="form-group" style="text-align: center">
    <input class="form-control" style="width: auto; display: inline">
    <button class="form-control" style="width: auto;display: inline">Add Location</button>
</div-->
<div id="zoneContainer" class="row" style="padding: 2%">

    <!--Container for Order List-->
    <!--div class="col-md-2">

    </div-->

    <!--First Column of Zones-->
    <div id="zoneCol1Container" class="col-md-6">
        <div class="table-responsive" style="width:100%; margin:0">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th  class="col-md-2">Zone</th>
                    <th  class="col-md-3">Add Cab</th>
                    <th  class="col-md-5">Avail. Cabs</th>

                </tr>
                </thead>
                <tbody data-bind="foreach:ZonesColumn1">
                <tr>
                    <td class="col-md-2" data-bind="text:name" ></td>
                    <td class="col-md-3">
                        <input data-bind="attr:{id:id}, value:cabInput" class="form-control cabInput" type="text">
                        <button data-bind="click:$root.addCab" class="form-control cabAdd">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </td>
                    <td class="col-md-5">
                        <ul style="display: inline" class="cabs" data-bind="foreach:cabs">
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
                                                            <td><span>Is Tinted?</span></td>
                                                            <td><span data-bind="text:attributes.isTinted"></span></td>
                                                        </tr>

                                                        <tr>
                                                            <td><span>Is Marked?</span></td>
                                                            <td><span data-bind="text:attributes.isMarked"></span></td>
                                                        </tr>

                                                        <tr>
                                                            <td><span>Current Location</span></td>
                                                            <td><span data-bind="text:currentLocation"></span></td>
                                                        </tr>

                                                        </tbody>
                                                    </table>

                                                    <div class="row" style="float:right; margin:0">
                                                        <button class="btn btn-success" data-bind="click:$root.dispatchCab.bind($data , $parent )">Dispatch</button>
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
                    <th  class="col-md-5">Avail. Cabs</th>

                </tr>
                </thead>
                <tbody data-bind="foreach:ZonesColumn2">
                <tr>
                    <td class="col-md-2" data-bind="text:name" ></td>
                    <td class="col-md-3">
                        <input data-bind="attr:{id:id}, value:cabInput" class="form-control cabInput" type="text">
                        <button data-bind="click:$root.addCab" class="form-control cabAdd">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </td>
                    <td class="col-md-5">
                        <ul style="display: inline" class="cabs" data-bind="foreach:cabs">
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

                                                    <div class="row" style="float:right; margin:0">
                                                        <button class="btn btn-success" data-bind="click:$root.dispatchCab.bind($data , $parent )">Dispatch</button>
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



<script type="text/javascript" src="<?= base_url();?>assets/js/LocationBoardScripts/ViewModel.js" charset="UTF-8"></script>


</body>
</html>