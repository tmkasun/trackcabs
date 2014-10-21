function createBooking(url , tp){
    var baseUrl = url;
    url = baseUrl + "/customer_retriever/addBooking";

    var no          = document.getElementById("no").value;
    var road        = document.getElementById("road").value;
    var city        = document.getElementById("city").value;
    var town        = document.getElementById("town").value;
    var landMark    = document.getElementById("landMark").value;
    var remark      = document.getElementById("remark").value;

    var vType="";

    if(document.getElementById('carRadio').checked) {
        vType = 'car';
    }
    if(document.getElementById('vanRadio').checked) {
        vType = 'van';
    }
    if(document.getElementById('vanRadio').checked) {
        vType = 'nano';
    }

    var payType="";

    if(document.getElementById('cashRadio').checked) {
        payType = 'cash';
    }
    if(document.getElementById('creditRadio').checked) {
        payType = 'credit';
    }

    var address = {'no':no , 'road' : road ,'city' : city , 'town' : town , 'landmark' : landMark}
    var data = {'tp' : tp , 'data' : {'address' : address , 'vType' : vType , 'payType' : payType ,
                'bDate' : "2010-01-15", 'bTime' : "00:00:00" , 'status' : 'start' , 'cabID' : '', 'driverId' : '',
                'remark' : remark , 'inqCall' : 0}};
    var result = ajaxPost(data,url);

    getCustomerInfoView(baseUrl , tp);
}


function editCustomerInfoEditView( url , tp ){
    url = url + "/cro_controller/loadCustomerInfoEditView";
    var data = {'tp' : tp};
    var view = ajaxPost(data,url);
    var div = document.getElementById('customerInformation');
    div.innerHTML = "";
    div.innerHTML = view.view.table_content;

}

function createCusInfo(url){
    var siteUrl = url;
    url = siteUrl + "/customer_retriever/createCustomer";
    var tp      = document.getElementById("tp").value;
    var tp2     = document.getElementById("tp2").value;
    var cusName = document.getElementById("cusName").value;
    var pRemark = document.getElementById("pRemark").value;
    var org     = document.getElementById("organization").value;
    var des     = document.getElementById("destination").value;
    /* Get the title from the select drop down*/
    var dropTitle = document.getElementById("title");
    var title = dropTitle.options[dropTitle.selectedIndex].value;

    /* Get the position from the select drop down*/
    var dropPos = document.getElementById("position");
    var position = dropPos.options[dropPos.selectedIndex].value;

    var type1 = 'mobile';
    var type2 = 'mobile';

    if(document.getElementById('type1').checked) {
        type1='land'
    }
    if(document.getElementById('type2').checked) {
        type2='land'
    }

    /* Added extra info to the customer object of total job and job cancellations */
    var data = { 'tp' : tp , 'type1' : type1 , 'tp2' : tp2 , 'type2' : type2 ,'name' : cusName , 'pRemark' : pRemark ,
                'org' : org , 'des' : des, 'title' : title , 'position' : position, 'dis_cancel' : 0 , 'tot_cancel' : 0,
                'tot_job' : 0 };
    ajaxPost(data,url);
    getCustomerInfoView(siteUrl , tp);
}

function updateCustomerInfoView(url){

    var siteUrl = url;
    url = siteUrl + "/customer_retriever/updateCustomer";
    var tp      = document.getElementById("tp").value;
    var tp2     = document.getElementById("tp2").value;
    var cusName = document.getElementById("cusName").value;
    var pRemark = document.getElementById("pRemark").value;
    var org     = document.getElementById("organization").value;
    var des     = document.getElementById("destination").value;
    /* Get the title from the select drop down*/
    var dropTitle = document.getElementById("title");
    var title = dropTitle.options[dropTitle.selectedIndex].value;

    /* Get the position from the select drop down*/
    var dropPos = document.getElementById("position");
    var position = dropPos.options[dropPos.selectedIndex].value;

    var type1 = 'mobile';
    var type2 = 'mobile';

    if(document.getElementById('type1').checked) {
        type1='land'
    }
    if(document.getElementById('type2').checked) {
        type2='land'
    }

    var data = { 'tp' : tp , 'data' : {'tp' : tp , 'type1' : type1 , 'tp2' : tp2 , 'type2' : type2 ,'name' : cusName , 'pRemark' : pRemark ,
        'org' : org , 'des' : des, 'title' : title , 'position' : position }};
    var result = ajaxPost(data,url);
    getCustomerInfoView(siteUrl , tp);
}

function getCustomerInfoView( url , tp ){

    url = url + "/cro_controller/getCustomerInfoView";
    var data = {"tp" : tp};
    var view = ajaxPost(data,url);
    /*  Populate the customer information view */
    var cusInfoDiv = document.getElementById('customerInformation');
    cusInfoDiv.innerHTML = "";
    cusInfoDiv.innerHTML = view.view.table_content;

    /*  Populate the job information view */
    var jobInfoDiv = document.getElementById('jobInfo');
    jobInfoDiv.innerHTML = "";
    jobInfoDiv.innerHTML = view.view.job_info_view;

    /*  Populate the job information view */
    var newBookingDiv = document.getElementById('newBooking');
    newBookingDiv.innerHTML = "";
    newBookingDiv.innerHTML = view.view.new_booking_view;
}

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
