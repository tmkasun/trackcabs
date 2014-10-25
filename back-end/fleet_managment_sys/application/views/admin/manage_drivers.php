<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-------------------------------- JS Files------------------------------------>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.10.2.js');?>"></script>
</head>
<body>

<button onclick="createDriver()">create Driver</button></br>

<script>
    function createDriver(){
        var data = {'name' : 'nirojan' , 'pass' : '123' , 'cabId' : '2' , 'info' : 'can speak english and tamil' };
        var url = '<?php echo site_url("driver_retriever/createDriver") ?>';
        var result=ajaxPost(data,url);
        alert(JSON.stringify(result));
    }

    function getDriver(){
        var data = {'driverId' : '1'};
        var url = '<?php echo site_url("driver_retriever/getDriver") ?>';
        var result=ajaxPost(data,url);
        alert(JSON.stringify(result));
    }

    function getAllDrivers(){
        var data = {};
        var url = '<?php echo site_url("driver_retriever/getAllDrivers") ?>';
        var result=ajaxPost(data,url);
        alert(JSON.stringify(result));
    }

    function get

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
                alert(result.statusMsg);
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