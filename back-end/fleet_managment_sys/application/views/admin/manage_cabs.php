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

        var docs_per_page= 100;
        var page = 1;
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
<!--            <li><a href="#" id="driver" onclick="getDriversView(this.id)">Drivers</a></li>-->
            <li><a href="#" id="driver" onclick="getCROsView(this.id)">Drivers</a></li>
<!--            <li><a href="#" id="dispatcher" onclick="getDispatchersView(this.id)">Dispatcher</a></li>-->
            <li><a href="#" id="dispatcher" onclick="getCROsView(this.id)">Dispatcher</a></li>
            <li><a href="#" id="cro" onclick="getCROsView(this.id)">CRO</a></li>
            <li><a href="#" id="accounts" onclick="getAccountsView(this.id)">Accounts</a></li>
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
                <li><a href="<?= site_url('login/logout')?>">Log Out</a></li>
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
                <div class="panel-heading" style="margin-top: 10px; border-left: 1px solid #a6a6a6" >
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
<!-- Driver javascript-->
<script>
    function getDriver(){alert("in getDriver");

        var driverId = document.getElementById("driverIdSearch").value;
        /* Create a JSON object from the form values */
        var driver = { 'driverId' : parseInt(driverId) };
        var url = '<?php echo site_url("driver_retriever/getDriver") ?>';
        var result = ajaxPost(driver,url);

    }
    function getDriverView(){alert("in getDriverView");

        var driverId = document.getElementById("driverIdSearch").value;
        /* Create a JSON object from the form values */
        var driver = { 'driverId' : parseInt(driverId) };
        var url = '<?php echo site_url("driver_retriever/getDriverSearchView") ?>';
        var result = ajaxPost(driver,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    }

    function makeDriverFormEditable(driverId , url){alert("in makeDriverFormEditable");

        var data = {'driverId' : parseInt(driverId) };
        url =url + "/driver_retriever/getDriverEditView";
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.driver_edit_view;
    }

    function updateDriver(url , docs_per_page , page ){alert("in updateDriver");

        var driverId = document.getElementById("driverId").value;
        var name = document.getElementById("name").value;
        var uName = document.getElementById("uName").value;
        var pass = document.getElementById("pass").value;
        var nic = document.getElementById("nic").value;
        var tp = document.getElementById("tp").value;
        var cabIdAssigned = document.getElementById("cabIdAssigned").value;
         /* Returns the function if validation fails */
         /* Create a JSON object from the form values */

        var driver =  {'driverId': parseInt(driverId) , 'details' : {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp ,'cabId' : cabIdAssigned }};
        var baseUrl=url;
        var url = '<?php echo site_url("driver_retriever/updateDriver") ?>';
        ajaxPost(driver,url);
        getAllDriversView(docs_per_page , page ,baseUrl);
    }

    function getDriversView(){alert("in getDriversView");
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

    function getNewDriverView(){alert("in getNewDriverView");

        var data = {};
        var url = '<?php echo site_url("driver_retriever/getNewFormDriverView") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;
    }

    function createNewDriver(){alert("in createNewDriver");
        var name = document.getElementById("name").value;
        var uName = document.getElementById("uName").value;
        var pass = document.getElementById("pass").value;
        var nic = document.getElementById("nic").value;
        var tp = document.getElementById("tp").value;
        var cabIdAssigned = document.getElementById("cabIdAssigned").value;
        if(name == "" ){return false;}
        if(uName == "" ){return false;}
        if(pass == "" ){return false;}
        if(nic == "" ){return false;}
        if(tp == "" ){return false;}

        if(cabIdAssigned == "" ){cabIdAssigned="null"}
        /* Create a JSON object from the form values */
        var driver = {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp ,'cabId' : cabIdAssigned };
        var url = '<?php echo site_url("driver_retriever/createDriver") ?>';
        alert(JSON.stringify(driver));
        ajaxPost(driver,url);
        getAllDriversView();
    }

    /* Gets all available cabs and show in the 'dataFiled' div tag */
    function getAllDriversView(){alert("in getAllDriversView");
        var skip = docs_per_page * (page-1);
        var data = {"skip" : skip , "limit" : docs_per_page};
        var url = '<?php echo site_url("driver_retriever/getAllDriversView") ?>';
        var view = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        div.innerHTML = view.view.table_content;

    }
</script>

<!-- Dispatcher javascript-->
<script>
    function getDispatcher(){alert("in getDispatcher");

        var dispatcherId = document.getElementById("dispatcherIdSearch").value;
        /* Create a JSON object from the form values */
        var driver = { 'dispatcherId' : parseInt(dispatcherId) };
        var url = '<?php echo site_url("dispatcher_retriever/getDispatcher") ?>';
        var result = ajaxPost(driver,url);

    }
    function getDispatcherView(){alert("in getDispatcherView");

        var dispatcherId = document.getElementById("dispatcherIdSearch").value;
        /* Create a JSON object from the form values */
        var dispatcher = { 'dispatcherId' : parseInt(dispatcherId) };
        var url = '<?php echo site_url("dispatcher_retriever/getDispatcherSearchView") ?>';
        var result = ajaxPost(dispatcher,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    }

    function makeDispatcherFormEditable(dispatcherId , url){alert("in makeDispatcherFormEditable");

        var data = {'dispatcherId' : parseInt(dispatcherId) };
        url =url + "/dispatcher_retriever/getDispatcherEditView";
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.dispatcher_edit_view;
    }

    function getDispatchersView(){alert("in getDispatchersView");
        var data = {};
        /* Get the nav bar for driver management view */
        var url = '<?php echo site_url("dispatcher_retriever/getDispatcherNavBarView") ?>';
        var result = ajaxPost(data,url);
        /* Append the values for the div tag field */
        var div = document.getElementById('navBarField');
        div.innerHTML = result.view.table_content;

        url = '<?php echo site_url("dispatcher_retriever/getSidePanelView") ?>';
        result = ajaxPost(data,url);
        div = document.getElementById('operation');
        div.innerHTML =  result.view.table_content;

        getAllDispatchersView();
    }
    function createNewDispatcher(){alert("in createNewDispatcher");
        var name = document.getElementById("name").value;
        var uName = document.getElementById("uName").value;
        var pass = document.getElementById("pass").value;
        var nic = document.getElementById("nic").value;
        var tp = document.getElementById("tp").value;

        if(name == "" ){return false;}
        if(uName == "" ){return false;}
        if(pass == "" ){return false;}
        if(nic == "" ){return false;}
        if(tp == "" ){return false;}
        /* Create a JSON object from the form values */
        var dispatcher = {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp};
        var url = '<?php echo site_url("dispatcher_retriever/createDispatcher") ?>';
        alert(JSON.stringify(dispatcher));
        ajaxPost(dispatcher ,url);
        getAllDispatchersView();
    }

    function getAllDispatchersView(){alert("in getAllDispatchersView");
        var skip = docs_per_page * (page-1);
        var data = {"skip" : skip , "limit" : docs_per_page};
        var url = '<?php echo site_url("dispatcher_retriever/getAllDispatchersView") ?>';
        var view = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        div.innerHTML = view.view.table_content;

    }

    function getNewDispatcherView(){alert("in getNewDispatcherView");

        var data = {};
        var url = '<?php echo site_url("dispatcher_retriever/getNewFormDispatcherView") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;
    }

    function updateDispatcher(url , docs_per_page , page ){alert("in updateDispatcher");
        var dispatcherId = document.getElementById("dispatcherId").value;
        var name = document.getElementById("name").value;
        var uName = document.getElementById("uName").value;
        var pass = document.getElementById("pass").value;
        var nic = document.getElementById("nic").value;
        var tp = document.getElementById("tp").value;
        var dispatcher =  {'dispatcherId': parseInt(dispatcherId) , 'details' : {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp}};
        var baseUrl=url;
        var url = '<?php echo site_url("dispatcher_retriever/updateDispatcher") ?>';
        ajaxPost(dispatcher,url);
        getAllDispatchersView(docs_per_page , page ,baseUrl);
    }

</script>

<!-- User javascript-->
<script>
    function getCRO(){//alert("in getCRO");

        var userId = document.getElementById("userIdSearch").value;
        /* Create a JSON object from the form values */
        var user = { 'userId' : parseInt(userId) };
        var url = '<?php echo site_url("user_controller/getUser") ?>';
        var result = ajaxPost(user,url);

    }
    function getCROView(id){//alert("in getCROView");

        var userId = document.getElementById("userIdSearch").value;
        /* Create a JSON object from the form values */
        var user = { 'userId' : parseInt(userId), 'user_type': id };
        var url = '<?php echo site_url("user_controller/getUserSearchView") ?>';
        var result = ajaxPost(user,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    }

    function makeCROFormEditable(userId , url, user_type){//alert("in makeCROFormEditable "+user_type);

        var data = {'userId' : parseInt(userId), 'user_type' : user_type };
        url =url + "/user_controller/getUserEditView";
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = eval("result.view."+user_type+"_edit_view");//result.view.type_edit_view;
    }

    function updateCRO(id){//alert("in updateCRO");

        var userId = document.getElementById("userId").value;
        var name = document.getElementById("name").value;
        var uName = document.getElementById("uName").value;
        var pass = document.getElementById("pass").value;
        var nic = document.getElementById("nic").value;
        var tp = document.getElementById("tp").value;
        var blocked = document.getElementById("blocked").value;
        var cabId = "";
        var logout = "false";
        if(id.toString() === "driver" )
        {
            cabId = document.getElementById("cabId").value;
            logout = document.getElementById("logout").value;
            //json object for 'user_type' 'driver'....when driver edited, 'logout' alwys set to false
            var user =  {'userId': parseInt(userId) , 'details' : {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp, 'cabId' : cabId, 'logout': logout , 'blocked':blocked}};
        }
        //jason object when for 'user_type's 'cro', and 'dispatcher' 
        else{var user =  {'userId': parseInt(userId) , 'details' : {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp , 'blocked':blocked}};}
        //else{var user =  {'userId': parseInt(userId) , 'details' : {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp, 'cabId' : cabId}};}
        
        var url = '<?php echo site_url("user_controller/updateUser") ?>';
        ajaxPost(user,url);        
        getAllCROsView(id);
    }

    function getCROsView(id){//alert("in getCROsView");
        var data = {'user_type': id};//alert(id);
        /* Get the nav bar for cro management view */
        var url = '<?php echo site_url("user_controller/getUserNavBarView") ?>';
        var result = ajaxPost(data,url);
        /* Append the values for the div tag field */
        var div = document.getElementById('navBarField');//alert("CRO NavBar ok");
        div.innerHTML = result.view.table_content;

        url = '<?php echo site_url("user_controller/getSidePanelView") ?>';
        result = ajaxPost(data,url);//alert("CRO SideBar ok");

        div = document.getElementById('operation');
        div.innerHTML =  result.view.table_content;

        getAllCROsView(id);
    }    
    

    function getNewCROView(id){//alert("in getNewCROView");

        var data = {'user_type' : id};
        var url = '<?php echo site_url("user_controller/getNewFormUserView") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;
    }

    function createNewCRO(id){//alert("in createNewCRO");
        var name = document.getElementById("name").value;
        var uName = document.getElementById("uName").value;
        var pass = document.getElementById("pass").value;
        var nic = document.getElementById("nic").value;
        var tp = document.getElementById("tp").value;
        var user_type = id;
        var cabId = "";        
        
        if(name == "" ){return false;}
        if(uName == "" ){return false;}
        if(pass == "" ){return false;}
        if(nic == "" ){return false;}
        if(tp == "" ){return false;}

        if(id.toString() === "driver" )
        {
            cabId = document.getElementById("cabId").value;
            //json object for 'user_type' 'driver'
            var user = {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp, 'user_type' : user_type, 'cabId' : cabId, 'logout':'false' , 'blocked':'false' ,'lastLogout':'0'};
        }
        //jason object when for 'user_type's 'cro', and 'dispatcher' 
        else{var user = {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp, 'user_type' : user_type  , 'blocked':'false' };}
        //else{var user = {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp, 'user_type' : user_type, 'cabId' : cabId };}
        var url = '<?php echo site_url("user_controller/createUser") ?>';
        alert(JSON.stringify(user));
        ajaxPost(user,url);
        getAllCROsView(id);
    }

    /* Gets all available cabs and show in the 'dataFiled' div tag */
    function getAllCROsView(id){//alert("in getAllCROsView");
        var skip = docs_per_page * (page-1);//alert("the id val in getALLCROView is : "+id);
        var data = {"skip" : skip , "limit" : docs_per_page, "user_type" : id};
        var url = '<?php echo site_url("user_controller/getAllUsersView") ?>';
        var view = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        div.innerHTML = view.view.table_content;

    }
</script>
<!-- Account javascript-->
<script>
    function getAccountViewFromDriverId(){

        url ='<?php echo site_url("/accounts_controller/getAccountsViewByDriverId") ?>';
        var driverId = document.getElementById("driverIdSearch").value;
        /* Create a JSON object from the form values */
        var driver = { 'driverId' : driverId };
        var result = ajaxPost(driver,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    }
    
    function getAccountsView(){

            var url = '<?php echo site_url("accounts_controller/getAccountsNavBarView") ?>';            
            var result = ajaxPost(null,url);//alert("before call");
            /* Append the values for the div tag field */
            var div = document.getElementById('navBarField');//alert("CRO NavBar ok");
            div.innerHTML = "";
            div.innerHTML = result.view.table_content;//alert("ok");

            url = '<?php echo site_url("accounts_controller/getSidePanelView") ?>';
            result = ajaxPost(null,url);//alert("CRO SideBar ok");
            div = document.getElementById('operation');
            div.innerHTML =  result.view.table_content;
            
            url ='<?php echo site_url("accounts_controller/getAllAccountsView") ?>'//url + "/accounts_controller/getAllAccountsView";
            var skip = docs_per_page * (page-1);
            var data = {"skip" : skip , "limit" : docs_per_page};
            var view = ajaxPost(data,url);
            var div = document.getElementById('dataFiled');
            div.innerHTML = "";
            div.innerHTML = view.view.table_content;//alert("ok2");


    }
    
    function updateAccounts(id,bookingChargeId){

        var bookingCharge = document.getElementById(bookingChargeId).value;
        var refId = document.getElementById(id).innerHTML;
        var account = {'refId': refId , 'bookingCharge' : bookingCharge};
        //var url = '<?php //echo site_url("accounts_controller/updateFee") ?>';
        //ajaxPost(account,url);
        document.getElementById("amount_percentage").innerHTML = Math.floor(((bookingCharge/100)*17));//parseInt(bookingCharge)
        //console.log(Math.floor(((bookingCharge/17)*100)));
        //getAccountsView();
    }
</script>>
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