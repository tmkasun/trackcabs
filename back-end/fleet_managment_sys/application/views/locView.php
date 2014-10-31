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
                    <td class="col-md-5"><button class="form-control cabDispatch">Dispatch</button></td>

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