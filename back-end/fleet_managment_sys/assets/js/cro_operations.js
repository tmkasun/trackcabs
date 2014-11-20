$(document).ready(function(){
    uiInit();
});

function addInquireCall(url , objId){

    var data = {'objId' : objId};
    url = url +"/customer_retriever/addInquireCall";
    var view = ajaxPost(data,url);

}

function getEditBookingView(url , objId){
    var data = {'objId' : objId};
    url = url +"/cro_controller/getEditBookingView";
    var view = ajaxPost(data,url);
    /*  Populate the New Booking field with the editing form */
    $('#newBooking').html(view.view.edit_booking_view);
    uiInit();
    /* The ui bug with only can select the vehicle type */
    var index = -1;
    for(var i=0 ; i < bookingObj.length ; i++){
        index++;
        if( bookingObj[i]['_id']['$id'] === bookingObjId){
            break;
        }
    }

    var payType = bookingObj[index]['payType'];
    var vType = bookingObj[index]['vType'];
    if(vType == 'car'){
        $('#carRadio').addClass(' active');
    }
    if(vType == 'van'){
        $('#vanRadio').addClass(' active');
    }
    if(vType == 'nano'){
        $('#nanoRadio').addClass(' active');
    }

    if(payType == 'cash')
    $('#payTypeCash').addClass(' active');

    if(payType == 'credit')
        $('#payTypeCredit').addClass(' active');
}

    function getCancelConfirmationView( url ,  bookingObjId ){

    var data = {'_id' : bookingObjId };
    url = url +"/cro_controller/getCancelConfirmationView";
    var view = ajaxPost(data,url);

    /*  Populate the job information view with cancel confirmation view*/
    $('#bookingStatus').html(view.view.cancel_confirmation_view);
}


function confirmCancel(url , tp , bookingObjId ){
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

    var data = {'_id' : bookingObjId , 'cancelReason' : cancelReason, 'tp' : tp};
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
    var destination = $('#destination').val();
    var pagingBoard = $('#pagingBoard').val();
    var bDate      = $('#bDate').val();
    var bTime      = $('#bTime').val();
    var vType               = $('#vehicleType').val();
    var payType             = $('#paymentType').val();
    var isUnmarked          = $('#unmarked')[0].checked;
    var isTinted            = $('#tinted')[0].checked;
    var isVip               = $('#vip')[0].checked;
    var isVih               = $('#vih')[0].checked;
    var isCusNumberNotSent  = $('#cusNumberNotSent')[0].checked;
    var bookingCharge = '-';
    var bookingType = 'Personal';
    var personalProfileTp = '-';

    if($('#personalProfileTp').length != 0){
        bookingType = 'Cooperate';
        personalProfileTp = $('#personalProfileTp').val();
    }

    if (no == ''){no = '-'}
    if (road == ''){road= '-'}
    if (city== ''){city= '-'}
    if (town== ''){town= '-'}
    if (landMark== ''){landMark= '-'}
    if (remark== ''){remark= '-'}
    if (callUpPrice== ''){callUpPrice= 0}
    if (dispatchB4== ''){dispatchB4= 30}
    if (destination== ''){destination= '-'}
    if (pagingBoard== ''){pagingBoard= '-'}

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
            'inqCall'      : 0,
            'callUpPrice' : callUpPrice,
            'dispatchB4' : dispatchB4,
            'pagingBoard' : pagingBoard,
            'destination' : destination,
            'bookingCharge' : bookingCharge,
            'bookingType' : bookingType,
            'personalProfileTp' : personalProfileTp
        }
    };
    ajaxPost(data,url,false);
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
    var destination = $('#destination').val();
    var dispatchB4  = $('#dispatchB4').val();
    var pagingBoard = $('#pagingBoard').val();
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
            'dispatchB4' : dispatchB4,
            'pagingBoard' : pagingBoard
        }
    };
    alert(JSON.stringify(data));
    //ajaxPost(data,url);
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
    var profileType = $('#profileType').val();

    var type1 = 'mobile';
    var type2 = 'mobile';

    if(document.getElementById('type1').checked) {
        type1='land'
    }
    if(document.getElementById('type2').checked) {
        type2='land'
    }

    if(tp == ''){
        alert('Telephone Number is Important');
        return false;
    };
    if(tp2 == ''){ tp2 = '-' };

    /* Added extra info to the customer object of total job and job cancellations */
    var data = {
        'profileType' : profileType ,
        'tp' : tp ,
        'type1' : type1 ,
        'tp2' : tp2 ,
        'type2' : type2 ,
        'name' : cusName ,
        'pRemark' : pRemark ,

        'org' : org ,
        'title' : title ,
        'position' : position,
        'dis_cancel' : 0 ,
        'tot_cancel' : 0,
        'tot_job' : 0
    };

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
    var profileType = $('#profileType').val();

    var type1 = 'mobile';
    var type2 = 'mobile';

    if(document.getElementById('type1').checked) {
        type1='land'
    }
    if(document.getElementById('type2').checked) {
        type2='land'
    }

    var data = {
        'profileType' : profileType,
        'tp' : tp ,
        'data' :
            {   'tp' : tp ,
                'type1' : type1 ,
                'tp2' : tp2 ,
                'type2' : type2 ,
                'name' : cusName ,
                'pRemark' : pRemark ,
                'org' : org ,
                'title' : title ,
                'position' : position
            }
    };
    ajaxPost(data,url);
    getCustomerInfoView(siteUrl , tp);
}

function getCustomerInfoView( url , tp ){

    url = url + "/cro_controller/getCustomerInfoView";
    var data = {"tp" : tp};
    var view = ajaxPost(data,url);
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

    /*  Populate the job information view */
    $('#bookingHistory').html(view.view.booking_history_view);

    /*  Populate the job information view */
    $('#callHistory').html(view.view.call_history_view);
}

function getSimilarTpNumbers(url , tp){
    url = url + "/customer_retriever/getSimilarTpNumbers";
    var data = {"tp" : tp};
    var result = ajaxPost(data,url);
    return result['data'];
}

function ajaxPost(data,urlLoc, asynchronicity)    {
    var result=null;
    $.ajax({
        type: 'POST', url: urlLoc,
        contentType: 'application/json; charset=utf-8',
        data: JSON.stringify(data),
        async: asynchronicity ? true : false,
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
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });

    $('#form_date').datetimepicker({
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
    });
    $('#form_time').datetimepicker({
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

    $(".checkBoxMakeAppear").click(function(){
        $(this).parent().siblings('.checkBoxElementAppearing').toggle()
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

function changeJobInfoViewByRefId(bookingObjId){

    var index = -1;
    for(var i=0 ; i < bookingObj.length ; i++){
        index++;
        if( bookingObj[i]['_id']['$id'] === bookingObjId){
            break;
        }
    }

    var driverId = bookingObj[index]['driverId'];
    var cabId   = bookingObj[index]['cabId'];

    if(driverId == '-')  driverId = 'NOT_ASSIGNED';
    if(cabId == '-')  cabId = 'NOT_ASSIGNED';

    $('#jobRefId').html(bookingObj[index]['refId']);
    $('#jobStatus').html(bookingObj[index]['status']);
    $('#jobVehicleType').html(bookingObj[index]['vType']);
    $('#jobDriverId').html(driverId);
    $('#jobCabId').html(cabId);

    $('#jobAddress').html(bookingObj[index]['address']['no'] + ' , ' + bookingObj[index]['address']['road'] + ' , ' +
                        bookingObj[index]['address']['city'] + ' , ' + bookingObj[index]['address']['town'] + ' ,'  +
                        bookingObj[index]['address']['landmark']);
    $('#jobDestination').html(bookingObj[index]['destination']);
    $('#jobRemark').html(bookingObj[index]['remark']);

    var specifications = "";
    if(bookingObj[index]['isVip'])
        specifications =specifications + ' VIP |';
    if(bookingObj[index]['isVih'])
        specifications =specifications + ' VIH |';
    if(bookingObj[index]['isUnmarked'])
        specifications =specifications + ' UNMARK |';
    if(bookingObj[index]['isTinted'])
        specifications =specifications + ' TINTED |';

    if(specifications == '')
        specifications = '-';

    $('#jobSpecifications').html(specifications);

    var bookDate=new Date(bookingObj[index]['bookTime']['sec'] * 1000);
    var callDate=new Date(bookingObj[index]['callTime']['sec'] * 1000);

    $('#jobBookTime').html(bookDate.toDateString()+'</br>'+bookDate.toTimeString());
    $('#jobCallTime').html(callDate.toDateString()+'</br>'+callDate.toTimeString());
    $('#jobDispatchB4').html(bookingObj[index]['dispatchB4']);
    $('#jobPayType').html(bookingObj[index]['jobPayType']);

    $('#jobDriverTp').html(bookingObj[index]['driverTp']);
    $('#jobCabColor').html(bookingObj[index]['cabColor']);
    $('#jobCabPlateNo').html(bookingObj[index]['cabPlateNo']);
    $('#jobPagingBoard').html(bookingObj[index]['pagingBoard']);
    $('#jobInquireButton').html(bookingObj[index]['inqCall']);



    var status = bookingObj[index]['status'];
    if( status == 'START' ||  status == 'MSG_COPIED' || status == 'MSG_NOT_COPIED' || status == 'AT_THE_PLACE') {
        $('#jobEditButton').html('<div class="btn-group"> <button type="button" class="btn btn-warning" onclick="operations(\'editBooking\', \''+ bookingObj[index]['_id']['$id']  +'\')">Edit Booking</button></div>');
    }

    if( status == 'START' ||  status == 'MSG_COPIED' || status == 'MSG_NOT_COPIED' || status == 'AT_THE_PLACE') {
        $('#jobCancelButton').html('<div class="btn-group"> <button type="button" class="btn btn-danger" onclick="operations(\'cancel\', \'' + bookingObj[index]['_id']['$id']   +  '\')">Cancel</button></div>');
    }
}

function addUserToCooperateProfile(url,tp){

    var siteUrl = url;
    url = url + "/customer_retriever/addCustomerToCooperateProfile";
    var userTp = $('#cooperateUserTp').val();
    var data = {"tp" : tp , "userTp" : userTp};
    var result = ajaxPost(data,url);
    if( result.status == false ){
        alert(result.message);
        return false;
    }
    getCustomerInfoView(siteUrl , tp);
}

function fillAddressToBooking(bookingObjId){

    var index = -1;
    for(var i=0 ; i < bookingObj.length ; i++){
        index++;
        if( bookingObj[i]['_id']['$id'] === bookingObjId){
            break;
        }
    }

    $('#no').val(bookingObj[index]['address']['no']);
    $('#road').val(bookingObj[index]['address']['road']);
    $('#city').val(bookingObj[index]['address']['city']);
    $('#town').val(bookingObj[index]['address']['town']);
    $('#landMark').val(bookingObj[index]['address']['landmark']);

}
