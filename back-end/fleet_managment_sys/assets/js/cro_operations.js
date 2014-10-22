function createBooking(url , tp){
    var baseUrl = url;
    url = baseUrl + "/customer_retriever/addBooking";

    var no          = $('#no').val();
    var road        = $('#road').val();
    var city        = $('#city').val();
    var town        = $('#town').val();
    var landMark    = $('#landMark').val();
    var remark      = $('#remark').val();
    var bDate      = $('#bDate').val();
    var bTIme      = $('#bTime').val();
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
                'bDate' : bDate, 'bTime' : bTIme , 'status' : 'start' , 'cabId' : '-', 'driverId' : '-',
                'remark' : remark , 'inqCall' : 0}};
    alert(JSON.stringify(data));

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
    var tp      = $('#tp').val();
    var tp2     = $('#tp2').val();
    var cusName = $('#cusName').val();
    var pRemark = $('#pRemark').val();
    var org     = $('#organization').val();
    var des     = $('#destination').val();
    var title = $('#title').val();
    var position = $('#position').val();

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
    var tp      = $('#tp').val();
    var tp2     = $('#tp2').val();
    var cusName = $('#cusName').val();
    var pRemark = $('#pRemark').val();
    var org     = $('#organization').val();
    var des     = $('#destination').val();
    var title = $('#title').val();
    var position = $('#position').val();

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

function getSimilarTpNumbers(url , tp){
    url = url + "/customer_retriever/getSimilarTpNumbers";
    var data = {"tp" : tp};
    var result = ajaxPost(data,url);
    return result['data'];
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
