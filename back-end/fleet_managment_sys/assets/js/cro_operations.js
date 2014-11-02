function getEditBookingView(url , objId){

    var data = {'objId' : objId};
    url = url +"/cro_controller/getEditBookingView";
    var view = ajaxPost(data,url);


    /*  Populate the New Booking field with the editing form */
    var editBookingDiv = document.getElementById('newBooking');
    editBookingDiv.innerHTML = "";
    editBookingDiv.innerHTML = view.view.edit_booking_view;

}

function getCancelConfirmationView( url , tp , id ){

    var data = {'_id' : id };
    url = url +"/cro_controller/getCancelConfirmationView";
    var view = ajaxPost(data,url);
    /*  Populate the job information view */

    var jobInfoDiv = document.getElementById('jobInfo');
    jobInfoDiv.innerHTML = "";
    jobInfoDiv.innerHTML = view.view.cancel_confirmation_view;

}


function confirmCancel(url , tp , id ){
    var siteUrl = url;
    var cancelReason="";
    url = siteUrl +"/customer_retriever/canceled";

    if(document.getElementById('cancel1Radio').checked) {
        cancelReason = 1;
    }
    if(document.getElementById('cancel2Radio').checked) {
        cancelReason = 2;
    }
    if(document.getElementById('cancel3Radio').checked) {
        cancelReason = 3;
    }
    if(document.getElementById('cancel4Radio').checked) {
        cancelReason = 4;
    }

    var data = {'_id' : id , 'cancelReason' : cancelReason, 'tp' : tp};

    ajaxPost(data,url);
    getCustomerInfoView(siteUrl , tp);
}


function createBooking(url , tp){
    var baseUrl = url;
    url = baseUrl + "/customer_retriever/addBooking";

    var no          = $('#no').val();
    var road        = $('#road').val();
    var city        = $('#city').val();
    var town        = $('#town').val();
    var landMark    = $('#landMark').val();
    var remark      = $('#remark').val();
    var callUpPrice = $('#callUpPrice').val();
    var dispatchB4  = $('#dispatchB4').val();
    var bDate      = $('#bDate').val();
    var bTime      = $('#bTime').val();
    var vType               = $('#vehicleType').val();
    var payType             = $('#paymentType').val();
    var isUnmarked          = $('#unmarked')[0].checked;
    var isTinted            = $('#tinted')[0].checked;
    var isVip               = $('#vip')[0].checked;
    var isVih               = $('#vih')[0].checked;
    var isCusNumberNotSent  = $('#cusNumberNotSent')[0].checked;

    if (no == ''){no = '-'}
    if (road == ''){road= '-'}
    if (city== ''){city= '-'}
    if (town== ''){town= '-'}
    if (landMark== ''){landMark= '-'}
    if (remark== ''){remark= '-'}
    if (callUpPrice== ''){callUpPrice= 0}
    if (dispatchB4== ''){dispatchB4= 30}

    var address = {
        'no':no ,
        'road' : road ,
        'city' : city ,
        'town' : town ,
        'landmark' : landMark
    };
    var data = {
        'tp' : tp ,
        'data' : {
            'address' : address ,
            'vType' : vType ,
            'payType' : payType ,
            'bDate' : bDate,
            'bTime' : bTime ,

            'isUnmarked':isUnmarked,
            'isTinted':isTinted,
            'isVip':isVip,
            'isVih':isVih,
            'isCusNumberNotSent':isCusNumberNotSent,

            'status' : 'START' ,
            'cabId' : '-',
            'driverId' : '-',
            'remark' : remark ,
            'inqCall' : 0,
            'callUpPrice' : callUpPrice,
            'dispatchB4' : dispatchB4
        }
    };
    ajaxPost(data,url);
    alert('booking added is working');
}


function updateBooking(url , objId){

    var baseUrl = url;
    url = baseUrl + "/customer_retriever/updateBooking";

    var no          = $('#no').val();
    var road        = $('#road').val();
    var city        = $('#city').val();
    var town        = $('#town').val();
    var landMark    = $('#landMark').val();
    var remark      = $('#remark').val();
    var callUpPrice = $('#callUpPrice').val();
    var dispatchB4  = $('#dispatchB4').val();
    var bDate      = $('#bDate').val();
    var bTime      = $('#bTime').val();
    var vType               = $('#vehicleType').val();
    var payType             = $('#paymentType').val();
    var isUnmarked          = $('#unmarked')[0].checked;
    var isTinted            = $('#tinted')[0].checked;
    var isVip               = $('#vip')[0].checked;
    var isVih               = $('#vih')[0].checked;
    var isCusNumberNotSent  = $('#cusNumberNotSent')[0].checked;


    var address = {
        'no':no ,
        'road' : road ,
        'city' : city ,
        'town' : town ,
        'landmark' : landMark
    };
    var data = {
        '_id' : objId,
        'data' : {
            'address' : address ,
            'vType' : vType ,
            'payType' : payType ,
            'bDate' : bDate,
            'bTime' : bTime ,

            'isUnmarked':isUnmarked,
            'isTinted':isTinted,
            'isVip':isVip,
            'isVih':isVih,
            'isCusNumberNotSent':isCusNumberNotSent,

            'status' : 'START' ,
            'cabId' : '-',
            'driverId' : '-',
            'remark' : remark ,
            'inqCall' : 0,
            'callUpPrice' : callUpPrice,
            'dispatchB4' : dispatchB4
        }
    };

    ajaxPost(data,url);
}

function editCustomerInfoEditView( url , tp ){
    url = url + "/cro_controller/getCustomerInfoEditView";
    var data = {'tp' : tp};
    var view = ajaxPost(data,url);
    $('#customerInformation').html(view.view.customer_info_edit_view);
}

function createCusInfo(url){
    var siteUrl = url;
    url = siteUrl + "/customer_retriever/createCustomer";
    var tp      = $('#tp').val();
    var tp2     = $('#tp2').val();
    var cusName = $('#cusName').val();
    var pRemark = $('#pRemark').val();
    var org     = $('#organization').val();
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
                'org' : org , 'title' : title , 'position' : position, 'dis_cancel' : 0 , 'tot_cancel' : 0,
                'tot_job' : 0 };
    ajaxPost(data,url);

}

function updateCustomerInfoView(url){

    var siteUrl = url;
    url = siteUrl + "/customer_retriever/updateCustomer";
    var tp      = $('#tp').val();
    var tp2     = $('#tp2').val();
    var cusName = $('#cusName').val();
    var pRemark = $('#pRemark').val();
    var org     = $('#organization').val();
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
        'org' : org , 'title' : title , 'position' : position }};
    ajaxPost(data,url);
    getCustomerInfoView(siteUrl , tp);
}

function getCustomerInfoView( url , tp ){

    url = url + "/cro_controller/getCustomerInfoView";
    var data = {"tp" : tp};
    var view = ajaxPost(data,url);
    alert('getcustomer info view is also completed');
    if(view.hasOwnProperty('important'))
    bookingObj=view.important.live_booking;

    if(view.hasOwnProperty('important'))
    customerObj=view.important.customerInfo;

    /*  Populate the customer information view */
    $('#customerInformation').html(view.view.customer_info_view);

    /*  Populate the job information view */
    $('#jobInfo').html(view.view.job_info_view);

    /*  Populate the job information view */
    $('#newBooking').html(view.view.new_booking_view);
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


function showCalender(){
    $('#form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });

    $('#form_date').datetimepicker({
    //language:  'fr',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
    });
    $('#form_time').datetimepicker({
    //language:  'fr',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0
    });
}

function uiInit(){
    $("#callUp").click(function(){
        $("#callUpPrice").toggle();
    });

    $(".btn-group > .btn").click(function(){
        $(this).addClass("active").siblings().removeClass("active");
        $(this).parent().siblings("input.customRadio").val($(this).val());
    });

    $("button.customRadio").click(function(){
        $(this).parent().siblings("input.customRadio").val($(this).val());
        $(this).parent().siblings("input.customRadio").text($(this).text())
    });
}

function changeJobInfoView(bookingObjId){

    alert(bookingObjId);
    alert(JSON.stringify(bookingObj));
    //$('#jobStatus').html()


}