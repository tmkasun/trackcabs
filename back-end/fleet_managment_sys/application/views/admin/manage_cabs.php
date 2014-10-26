<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-------------------------------- CSS Files------------------------------------>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.css">
    <!-------------------------------- JS Files------------------------------------>
    <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/admin_panel/admin_cab_operations.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/admin_panel/admin_driver_operations.js"></script>

    <script>

        var docs_per_page= 100 ;
        var page = 1 ;
        var obj = null;
        var url = '<?php echo site_url(); ?>';

    </script>
</head>
<body>

<div id="navBarField">
    <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Cao Cabs Admin Panel</a>
        </div>

        <ul class="nav navbar-nav">
            <li class="active"><a href="#" onclick="getAllCabs(docs_per_page , page , url)">Cabs</a></li>
            <li><a href="#" onclick="getDriversView()">Drivers</a></li>
        </ul>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <form class="navbar-form navbar-left" role="search" id="getCab">
                <div class="form-group">
                    <input class="form-control" placeholder="Cab ID" type="text" id="cabIdSearch">
                </div>
                <button type="submit" class="btn btn-default" onclick="getCabView(url)">Submit</button>
            </form>
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
    <div class="row">


        <div class="col-lg-12" style="margin-top: 10px">
            <div class="panel panel-default">
                <div class="panel-heading" style="margin-top: 10px; border-left: 1px solid #a6a6a6;>
                    <h3 class="panel-title">Info</h3>
                </div>
                <div class="panel-body" id="information">

                <div class="col-lg-2" id="operation" style="margin-top: 10px">
                    <h5><a href="#" onclick="getNewCabView(url)">New Cab</a></h5></br>
                    <h5><a href="#" onclick="getAllCabs(docs_per_page , page, url)">View All Cabs</a></h5>
                </div>

                <div class="col-lg-10" id="dataFiled" style="margin-top: 10px; border-left: 1px solid #a6a6a6;">
                </div>


                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getDriver(){

        var driverId = document.getElementById("driverIdSearch").value;
        /* Create a JSON object from the form values */
        var driver = { 'driverId' : parseInt(driverId) };
        var url = '<?php echo site_url("driver_retriever/getCab") ?>';
        var result = ajaxPost(driver,url);

    }
    function getDriverView(){

        var cabId = document.getElementById("cabIdSearch").value;
        /* Create a JSON object from the form values */
        var cab = { 'cabId' : parseInt(cabId) };
        var url = '<?php echo site_url("cab_retriever/getCabSearchView") ?>';
        var result = ajaxPost(cab,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    }

    function getDriversView(){
        var data = {};
        /* Get the nav bar for driver management view */
        var url = '<?php echo site_url("driver_retriever/getDriverNavBarView") ?>';
        var result = ajaxPost(data,url);
        /* Append the values for the div tag field */
        var div = document.getElementById('navBarField');
        div.innerHTML = result.view.table_content;

        url = '<?php echo site_url("driver_retriever/getSidePanelView") ?>';
        result = ajaxPost(data,url);

        div = document.getElementById('operation');
        div.innerHTML =  result.view.table_content;

        getAllDriversView();
    }

    function getNewDriverView(){

        var data = {};
        var url = '<?php echo site_url("driver_retriever/getNewFormDriverView") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;
    }

    function createNewDriver(){
        var name = document.getElementById("name").value;
        var uName = document.getElementById("uName").value;
        var pass = document.getElementById("pass").value;
        var nic = document.getElementById("nic").value;
        var tp = document.getElementById("tp").value;
        var cabIdAssigned = document.getElementById("cabIdAssigned").value;
        /* Create a JSON object from the form values */
        var driver = {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp ,'cabId' : cabIdAssigned };
        var url = '<?php echo site_url("driver_retriever/createDriver") ?>';
        alert(JSON.stringify(driver));
        ajaxPost(driver,url);
        getAllDriversView();
    }

    /* Gets all available cabs and show in the 'dataFiled' div tag */
    function getAllDriversView(){
        var skip = docs_per_page * (page-1);
        var data = {"skip" : skip , "limit" : docs_per_page};
        var url = '<?php echo site_url("driver_retriever/getAllDriversView") ?>';
        var view = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        div.innerHTML = view.view.table_content;

    }
</script>


<script>
    function validate(plateNo , model , vType , color , info ){
        var status = false;
        if(model == ""){
            alert("model filed is required");
            return status;
        }
        if(plateNo == ""){
            alert("plate number is required");
            return status;
        }
        if(vType == ""){
            alert("Vehicle type is required");
            return status;
        }
        return true;
    }
</script>


<script>
    function ajaxPost(data,urlLoc)    {
        var result=null;
        $.ajax({
            type: 'POST', url: urlLoc,
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: JSON.stringify(data),
            async: false,
            success: function(data, textStatus, jqXHR) {
                result = JSON.parse(jqXHR.responseText);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if(jqXHR.status == 400) {
                    var message= JSON.parse(jqXHR.responseText);
                    $('#messages').empty();
                    $.each(messages, function(i, v) {
                        var item = $('<li>').append(v);
                        $('#messages').append(item);
                    });
                } else {
                    alert('Unexpected server error.');
                }
            }
        });
        return result;
    }
</script>

</body>
</html>