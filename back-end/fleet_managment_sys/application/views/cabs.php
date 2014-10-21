<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-------------------------------- CSS Files------------------------------------>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/simple-sidebar.css">
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


<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#" onclick="getAllCabs()">Cabs Panel</a>
            </li>
            <li><a href="#" id="newCab" style="margin-left: 10%">New Cab</a></li>
            <li class="sidebar-brand">
                <a href="#" onclick="">Drivers Panel</a>
            </li>
            <li><a href="#" id="newCab">New Driver</a></li>
            <li class="sidebar-brand">
                <a href="#" onclick="getAllCabs()">CRO Panel</a>
            </li>
            <li><a href="#" id="newCab">New CRO</a></li>
            <li class="sidebar-brand">
                <a href="#" onclick="getAllCabs()">Dispatcher Panel</a>
            </li>
            <li><a href="#" id="newCab">New Dispatcher</a></li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12" id="navBarField">

                </div>

                <div class="col-lg-12" id="dataFiled" style="margin-top: 10px">
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    /* Function to get the input form from controller to add a new Cab */
    $('#newCab').click(function () {
        var data = {};
        var url = '<?php echo site_url("cab_retriever/getCabView") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    });
</script>

<script>
    function createNewCab(){
        var model = document.getElementById("model").value;
        var color = document.getElementById("color").value;
        var plateNo = document.getElementById("plateNo").value;
        var vType = document.getElementById("vType").value;
        var info = document.getElementById("info").value;
        /* Create a JSON object from the form values */
        var cab = {'model' : model , 'color' : color , 'plateNo' : plateNo , 'vType' : vType ,'info' : info };

        var url = '<?php echo site_url("cab_retriever/createCab") ?>';
        ajaxPost(cab,url);
        getAllCabs();
    }
</script>

<script>
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
    function getCab(){
        var cabId = document.getElementById("cabIdSearch").value;
        /* Create a JSON object from the form values */
        var cab = { 'cabId' : parseInt(cabId) };
        var url = '<?php echo site_url("cab_retriever/getCab") ?>';
        var result = ajaxPost(cab,url);

        var element="";
        obj = result.data;
        element = element+'cab ID : '+obj.cabId+'</br>'+
        'Plate Number : '+obj.plateNo+'</br>'+
        'Vehicle Type : '+obj.vType+'</br>';
        if(obj.model != null){
            element = element +'Model : '+obj.model+'</br>';
        }else{
            element = element +'Model : empty'+'</br>';
        }
        if(obj.info != null){
            element = element +'Info : '+obj.info+'</br>';
        }else{
            element = element +'Info : empty'+'</br>';
        }

        element = element + '<button onclick="makeCabFormEditable()" value="Edit"> Edit </button>';
        var div = document.getElementById('dataFiled');
        div.innerHTML = element;
    }
</script>

<script>
    /* Gets all available cabs and show in the 'dataFiled' div tag */
    function getAllCabs(){
        var skip = docs_per_page * (page-1);
        var data = {"skip" : skip , "limit" : docs_per_page};
        var url = '<?php echo site_url("cab_retriever/getCabsByPage") ?>';
        var result = ajaxPost(data,url);
        var element='<table class="table table-striped" ><tr><th>CAB ID</th><th>Plate Number</th><th>Vehicle Type</th><th>Model</th><th>Info</th></tr>';
        for(var i = 0; i < result.data.length; i++) {

            obj = result.data[i];
            element = element+ '<tr><td>'+obj.cabId+'</td><td>'+obj.plateNo+'</td><td>'+obj.vType+'</td>'+
                                '<td>'+ obj.model +'</td><td>'+obj.info+'</tr>';
        }
        var div = document.getElementById('dataFiled');
        div.innerHTML = element;

    }
</script>

<script>
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
</script>

<script>
    function getCabNavBar(){
        var data = {};
        var url = '<?php echo site_url("cab_retriever/getCabNavBar") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('navBarField');
        div.innerHTML = result.view.table_content;
    }
</script>

<script>
    /* Loads all the cab details after the page loads */
    window.onload = callList;
    function callList(){
        getCabNavBar();
        getAllCabs();
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



<!--
<form method="get" action="http://10.100.4.234:3000">
    <input type="text" name="mobile_number">
    <input type="text" name="message">
    <input type="submit" value="create message">
</form>
-->