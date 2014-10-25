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

    <script>

        var docs_per_page= 100 ;
        var page = 1 ;
        var obj = null;

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
            <li class="active"><a href="#" onclick="getAllCabs()">Cabs</a></li>
            <li><a href="#" onclick="getDriversView()">Drivers</a></li>
        </ul>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <form class="navbar-form navbar-left" role="search" id="getCab">
                <div class="form-group">
                    <input class="form-control" placeholder="Cab ID" type="text" id="cabIdSearch">
                </div>
                <button type="submit" class="btn btn-default" onclick="getCabView()">Submit</button>
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
                <div class="panel-heading">
                    <h3 class="panel-title">Info</h3>
                </div>
                <div class="panel-body" id="customerInformation">


                <div class="col-lg-2" id="operation" style="margin-top: 10px">
                    <h5><a href="#" onclick="getNewCabView()">New Cab</a></h5></br>
                    <h5><a href="#" onclick="getAllCabs()">View All Cabs</a></h5>
                </div>

                <div class="col-lg-10" id="dataFiled" style="margin-top: 10px">
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

        getCabSearchView();


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

    function makeCabFormEditable(){
        var data = {};
        var url = '<?php echo site_url("cab_retriever/getCabEditView") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

        var cabIdTextField = $('#cabId');
        var plateTextField = $('#plateNo');
        var modelTextField = $('#model');
        var vTypeTextField = $('#vType');
        var colorTextField = $('#color');
        var infoTextField = $('#info');

        cabIdTextField.val(cabIdTextField.val() +obj.cabId );
        plateTextField.val(plateTextField.val() +obj.plateNo );
        modelTextField.val(modelTextField.val() +obj.model );
        vTypeTextField.val(vTypeTextField.val() +obj.vType );
        colorTextField.val(colorTextField.val() +obj.color );
        infoTextField.val(infoTextField.val() +obj.info );
    }

    function updateCab(){
        var cabId = document.getElementById("cabId").value;
        var model = document.getElementById("model").value;
        var color = document.getElementById("color").value;
        var plateNo = document.getElementById("plateNo").value;
        var vType = document.getElementById("vType").value;
        var info = document.getElementById("info").value;
        /* Create a JSON object from the form values */
        var cab = {'cabId': parseInt(cabId) , 'details' : {'model' : model , 'color' : color , 'plateNo' : plateNo , 'vType' : vType ,'info' : info }};
        var url = '<?php echo site_url("cab_retriever/updateCab") ?>';
        ajaxPost(cab,url);
        getAllCabs();
    }

</script>


<script>
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
</script>

<script>
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
    function getCabView(){

        var cabId = document.getElementById("cabIdSearch").value;
        /* Create a JSON object from the form values */
        var cab = { 'cabId' : parseInt(cabId) };
        var url = '<?php echo site_url("cab_retriever/getCabSearchView") ?>';
        var result = ajaxPost(cab,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    }

    function makeCabFormEditable(cabId){
        var data = {'cabId' : parseInt(cabId) };
        var url = '<?php echo site_url("cab_retriever/getCabEditView") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;
    }

    function updateCab(){
        var cabId = document.getElementById("cabId").value;
        var model = document.getElementById("model").value;
        var color = document.getElementById("color").value;
        var plateNo = document.getElementById("plateNo").value;
        var vType = document.getElementById("vType").value;
        var info = document.getElementById("info").value;

        var status = validate(plateNo , model , vType , color , info);
        /* Returns the function if validation fails */
        if(status == false){return false;}

        if(color == "")color = "null";
        if(info == "")color = "null";

        /* Create a JSON object from the form values */
        var cab = {'cabId': parseInt(cabId) , 'details' : {'model' : model , 'color' : color , 'plateNo' : plateNo , 'vType' : vType ,'info' : info }};
        var url = '<?php echo site_url("cab_retriever/updateCab") ?>';
        ajaxPost(cab,url);
        getAllCabs();
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

    function getNewCabView(){
        var data = {};
        var url = '<?php echo site_url("cab_retriever/getNewCabView") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;
    }

    function createNewCab(){
        var model = document.getElementById("model").value;
        var color = document.getElementById("color").value;
        var plateNo = document.getElementById("plateNo").value;
        var vType = document.getElementById("vType").value;
        var info = document.getElementById("info").value;

        var status = validate(plateNo , model , vType , color , info);
        /* Returns the function if validation fails */
        if(status == false){return false;}
        /* */
        if(color == "")color = "null";
        if(info == "")color = "null";

        /* Create a JSON object from the form values */
        var cab = {'model' : model , 'color' : color , 'plateNo' : plateNo , 'vType' : vType ,'info' : info };

        var url = '<?php echo site_url("cab_retriever/createCab") ?>';
        ajaxPost(cab,url);
        getAllCabs();
    }
</script>

<script>
    /* Gets all available cabs and show in the 'dataFiled' div tag */
    function getAllCabs(){
        var skip = docs_per_page * (page-1);
        var data = {"skip" : skip , "limit" : docs_per_page};
        var url = '<?php echo site_url("cab_retriever/getAllCabsView") ?>';
        var view = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        div.innerHTML = view.view.table_content;

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