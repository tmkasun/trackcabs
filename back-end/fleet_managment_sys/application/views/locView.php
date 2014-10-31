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
<style>
    input.cabInput{
        width:65%;
        display: inline;
    }

    ul.cabs{
        list-style: none;
        padding: 0;
        margin: 0;
    }

    li.cab{
        display: inline;
    }

    button.cabDispatch{
        width: auto;
        display: inline;
        margin-bottom: 5px;

    }
    button.cabAdd{
        width: auto;
        display: inline;
        margin-bottom: 5px;

    }

    input{

    }




</style>
</head>
<body>
<h2 style="text-align: center; margin-bottom: 1%">Location Board</h2>
<div class="form-group" style="text-align: center">
    <input class="form-control" style="width: auto; display: inline">
    <button class="form-control" style="width: auto;display: inline">Add Location</button>
</div>
<div class="row" style="padding: 2%">
    <div class="col-md-6">
        <div class="table-responsive" style="width:100%; margin:auto 0 auto auto">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th  class="col-md-2">Location</th>
                    <th  class="col-md-2">Add Cab</th>
                    <th  class="col-md-6">Avail. Cabs</th>

                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-md-2">Rajagiriya</td>
                    <td class="col-md-2"><input class="form-control cabInput" type="text"><button class="form-control cabAdd">+</button></td>
                    <td class="col-md-6">
                        <ul class="cabs">
                            <li class="cab"><button class="btn btn-success dropdown-toggle cabDispatch" data-toggle="dropdown" aria-expanded="false">Cab 1001</button></li>
                            <li class="cab"><button class="btn btn-success dropdown-toggle cabDispatch" >Cab 1002</button></li>
                            <li class="cab"><button class="btn btn-success dropdown-toggle cabDispatch" >Cab 1003</button></li>
                            <li class="cab"><button class="btn btn-success cabDispatch" >Cab 1004</button></li>
                            <li class="cab"><button class="btn btn-success cabDispatch" >Cab 1005</button></li>
                            <li class="cab"><button class="btn btn-success cabDispatch" >Cab 1005</button></li>
                            <li class="cab"><button class="btn btn-success cabDispatch" >Cab 1006</button></li>

                        </ul>

                    </td>

                </tr>
                <tr>
                    <td class="col-md-2">Dematagoda</td>
                    <td class="col-md-2"><input class="form-control cabInput" type="text"><button class="form-control cabAdd">+</button></td>
                    <td class="col-md-6">
                        <ul class="cabs">
                            <li class="cab"><button class="form-control cabDispatch" >Cab 1001</button></li>
                            <li class="cab"><button class="form-control cabDispatch" >Cab 1002</button></li>
                            <li class="cab"><button class="form-control cabDispatch" >Cab 1003</button></li>
                            <li class="cab"><button class="form-control cabDispatch" >Cab 1004</button></li>
                            <li class="cab"><button class="form-control cabDispatch" >Cab 1005</button></li>
                            <li class="cab"><button class="form-control cabDispatch" >Cab 1005</button></li>
                            <li class="cab"><button class="form-control cabDispatch" >Cab 1006</button></li>

                        </ul>

                    </td>

                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="table-responsive" style="width:100%; margin:0">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th  class="col-md-2">Location</th>
                    <th  class="col-md-3">Add Cab</th>
                    <th  class="col-md-5">Avail. Cabs</th>

                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-md-2">Moratuwa</td>
                    <td class="col-md-3"><input class="form-control cabInput" type="text"><button class="form-control cabAdd">+</button></td>
                    <td class="col-md-5">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success">Cab 4455</button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Turbo Boost</a></li>
                                <li><a href="#">Teleport</a></li>
                                <li><a href="#">Submersible</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Other Options</a></li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success">Cab 6547</button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Turbo Boost</a></li>
                                <li><a href="#">Teleport</a></li>
                                <li><a href="#">Submersible</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Other Options</a></li>
                            </ul>
                        </div>

                        <div class="btn-group open">
                            <button type="button" class="btn btn-success">Cab 4455</button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu" style="  padding: 10px; min-width: 200%">

                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h2 class="panel-title">Cab 4455 Info</h2>
                                    </div>
                                    <div class="panel-body" style="padding: 4%">
                                        <div style="margin:0">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <span>Has Turbo Boost</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span>True</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <span>Has Teleportation</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span>True</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin: 0">

                                </div>

                            </div>
                        </div>
                    </td>


                </tr>
                <tr>
                    <td class="col-md-2">Galle</td>
                    <td class="col-md-3"><input class="form-control cabInput" type="text"><button class="form-control cabAdd">+</button></td>
                    <td class="col-md-5"><button class="form-control cabDispatch">Dispatch</button></td>

                </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>




</body>
</html>