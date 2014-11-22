/*
 *  Copyright (c) 2005-2010, WSO2 Inc. (http://www.wso2.org) All Rights Reserved.
 *
 *  WSO2 Inc. licenses this file to you under the Apache License,
 *  Version 2.0 (the "License"); you may not use this file except
 *  in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

var debugObject; // assign object and debug from browser console, this is for debugging purpose , unless this var is unused
var currentCabsList = {};
var selectedSpatialObject; // This is set when user search for an object from the search box
var webSocketURL = "ws://" + ApplicationOptions.constance.WEBSOCKET_URL + ":9763/outputwebsocket/t/carbon.super/DefaultWebsocketOutputAdaptor/alertsGeoJson";
var websocket;

// Make the function wait until the connection is made...
var waitTime = 1000;
function waitForSocketConnection(socket, callback) {
    setTimeout(
        function () {
            if (socket.readyState === 1) {
                initializeWebSocket();
                waitTime = 1000;
                console.log("Connection is made");
                if (callback != null) {
                    callback();
                }
                return;

            } else {
                websocket = new WebSocket(webSocketURL);
                waitTime += 400;
                $.UIkit.notify({
                    message: "wait for connection " + waitTime / 1000 + " Seconds...",
                    status: 'warning',
                    timeout: waitTime,
                    pos: 'top-center'
                });
                waitForSocketConnection(websocket, callback);
            }

        }, waitTime); // wait 5 milisecond for the connection...
}

var webSocketOnOpen = function () {
    $.UIkit.notify({
        message: 'You Are Connectedto Websocket Server!!',
        status: 'success',
        timeout: 3000,
        pos: 'top-center'
    });
};

var webSocketOnError = function (e) {
    $.UIkit.notify({
        message: 'Something went wrong when trying to connect to <b>' + webSocketURL + '<b/>',
        status: 'danger',
        timeout: 600,
        pos: 'top-center'
    });
//    waitForSocketConnection(websocket);
};

var webSocketOnClose = function (e) {
    $.UIkit.notify({
        message: 'Connection lost with server!!',
        status: 'danger',
        timeout: 600,
        pos: 'top-center'
    });
    waitForSocketConnection(websocket);
};

var webSocketOnMessage = function processMessage(message) {
    var geoJsonFeature = $.parseJSON(message.data);
    notifyAlert(geoJsonFeature.properties.orderId);
    $.getJSON("monitor/getOrder/" + geoJsonFeature.properties.orderId, function (order) {
        geoJsonFeature.properties.order = order;
        if (geoJsonFeature.id in currentCabsList) { // TODO: actual value properties.cabId
            console.log("DEBUG: geoJsonFeature.id in +" + geoJsonFeature.id);
            var excitingCab = currentCabsList[geoJsonFeature.id];
            excitingCab.update(geoJsonFeature);
        }
        else {
            console.log("DEBUG: geoJsonFeature.id not in =" + geoJsonFeature.id);
            var newOrder = new Cab(geoJsonFeature);
            newOrder.update(geoJsonFeature);
            currentCabsList[newOrder.id] = newOrder;
            //currentCabsList[newCab.id].addTo(map);// TODO: This should be add to monitor view
        }
    });
};

function initializeWebSocket() {
    websocket = new WebSocket(webSocketURL);
    websocket.onmessage = webSocketOnMessage;
    websocket.onclose = webSocketOnClose;
    websocket.onerror = webSocketOnError;
    websocket.onopen = webSocketOnOpen;
}

initializeWebSocket(); //TODO: uncomment to work websockets

/*----------------------- Cab Object Definition -----------------------*/

function Cab(geoJSON) {
    this.id = geoJSON.id; // TODO: actual ID geoJSON.properties.cabId;
    this.driver = {id: geoJSON.id};
    this.state = geoJSON.properties.state;
    this.speed = geoJSON.properties.speed;
    this.heading = geoJSON.properties.heading;
    this.orderId = geoJSON.properties.orderId;
    this.locationCoordinates = [geoJSON.geometry.coordinates];
    this.geoJson = geoJSON; // TODO: why again ?
    this.order = geoJSON.properties.order;

    return this;
}

Cab.prototype.locationName = function () {
    alert("Return location name by quiering DB for MBR $near using this.locationCoordinates");
};

Cab.prototype.addView = function () {
    alert("Add to correct panel");
};

Cab.prototype.setSpeed = function (speed) {
    this.speed = speed;
};

Cab.prototype.stateRow = function () {
    // Performance of if-else, switch or map based conditioning http://stackoverflow.com/questions/8624939/performance-of-if-else-switch-or-map-based-conditioning
    var currentTime = moment();
    switch (this.state) {
        case "IDLE":
            return (
            "<tr id='" + this.id + "'>" +
            '<td>' +
            this.driver.id +
            '</td>' +
            '<td>' +
            currentTime.format('Do-MMM-YY  hh:mm a') +
            '</td>' +
            '<td class = "locationName">' +
            setLocationName(this.locationCoordinates, '#' + this.id) +
            '</td>' +
            "</tr>"
            );

        case "MSG_COPIED":
            return (
            "<tr id='" + this.id + "'>" +
            '<td>' +
            this.geoJson.properties.orderId +
            '</td>' + '<td>' + 'N/A' + '</td>' + '<td>' + 'N/A' + '</td>' + '<td>' + currentTime.format('Do-MMM-YY  hh:mm a') + '</td>' + '<td>' + 'N/A' + '</td>' +
            '<td>' + this.geoJson.properties.cabId + '</td>' + '<td>' + 'N/A' + '</td>' + /*Address*/'<td>' + 'N/A' + '</td>' + /*agent*/'<td>' + 'N/A' + '</td>' +
                /*Inquire*/'<td>' + 'N/A' + '</td>' + /*DIM*/'<td>' + 'N/A' + '</td>' + /*VIH*/'<td>' + 'N/A' + '</td>' + /*VIP*/'<td>' + 'N/A' +
            '</td>' + '<td>' + 'N/A' + '</td>' + '</tr>'
            );
        case "AT_THE_PLACE":
            return (
            "<tr id='" + this.id + "'>" +
            '<td>' +
            this.geoJson.properties.orderId +
            '</td>' + '<td>' + 'N/A' + '</td>' + '<td>' + 'N/A' + '</td>' + '<td>' + currentTime.format('Do-MMM-YY  hh:mm a') + '</td>' + '<td>' + 'N/A' + '</td>' +
            '<td>' + this.geoJson.properties.cabId + '</td>' + '<td>' + 'N/A' + '</td>' + /*Address*/'<td>' + 'N/A' + '</td>' + /*agent*/'<td>' + 'N/A' + '</td>' +
                /*Inquire*/'<td>' + 'N/A' + '</td>' + /*DIM*/'<td>' + 'N/A' + '</td>' + /*VIH*/'<td>' + 'N/A' + '</td>' + /*VIP*/'<td>' + 'N/A' +
            '</td>' + '<td>' + 'N/A' + '</td>' + '</tr>'
            );
        case "POB":
            return (
            "<tr id='" + this.id + "'>" +
            '<td>' + this.geoJson.properties.orderId + '</td>' +
            '<td>' + moment.unix(this.order.bookTime.sec).format('Do-MMM-YY  hh:mm a') + '</td>' +
            '<td>' + currentTime.format('Do-MMM-YY  hh:mm a') + '</td>' +
            '<td class = "onHireTime" >' + moment.duration(moment().subtract(currentTime)).humanize() + '</td>' +
            '<td>' + this.geoJson.properties.cabId + '</td>' +
            '<td>' + this.order.driver.tp + '</td>' +
                /*Address*/
            '<td>' + addressToString(this.order.address)  + '</td>' +
                /*agent*/
            '<td>' + this.order.croId + '</td>' +
                /*Inquire*/
            '<td>' + this.order.inqCall + '</td>' +
                /*DIM*/
            '<td>' + this.getBadge(false) + '</td>' +
                /*VIH*/
            '<td>' + this.getBadge(this.order.isVih) + '</td>' +
                /*VIP*/
            '<td>' + this.getBadge(this.order.isVip) + '</td>' +
                /*COP*/
            '<td>' + this.getBadge(false) + '</td>' +
            '<td class = "locationName" >' + setLocationName(this.locationCoordinates, '#' + this.id) + '</td>' +

            '</tr>'
            );
        default:
            return null;
    }
};

Cab.prototype.getBadge = function (status) {
    var returnBadge;
    if (status) {
        returnBadge = '<span class="badge alert-info"><span style="color: #5cb85c" class="glyphicon glyphicon-ok"></span></span>';
    } else {
        returnBadge = '<span class="badge alert-warning"><span style="color: #d9534f" class="glyphicon glyphicon-remove"></span></span>';
    }
    return returnBadge;
};

Cab.prototype.update = function (geoJSON) {
    this.geoJson = geoJSON;
    this.locationCoordinates = geoJSON.geometry.coordinates;
    this.setSpeed(geoJSON.properties.speed);
    this.state = geoJSON.properties.state;
    this.heading = geoJSON.properties.heading;
    //this.orderDOM = $('#' + this.id);
    this.orderDOM = ($('#' + this.id).length != 0) ? $('#' + this.id) : $('#' + this.order.refId) ;
    if (this.orderDOM.length) {
        this.orderDOM.fadeOut().remove();
    }
    this.orderDOM = this.stateRow();
    if (this.state != "MSG_NOT_COPIED") {
        $('#' + this.state + ' > tbody:last').append(this.orderDOM);
    }
};

/*------------------------------ Helper methods ------------------------------*/
function addressToString(address){
    var addressString = "";
    $.each(address,function(key, value) {
        addressString+=value+'  ';
    });
    return addressString;
}

function setLocationName(latLng, domId) {
    $.post('testing/geoCode', {longitude: latLng[0], latitude: latLng[1]}, function (response) {
        var geoNames = JSON.parse(response);
        $(domId).find('.locationName').html(geoNames[0].name);
    });
}

function notifyAlert(message) {
    $.UIkit.notify({
        message: "Alert: " + message,
        status: 'warning',
        timeout: 5000,
        pos: 'bottom-left'
    });
}

/*function Alert(type, message, level) {
 this.type = type;
 this.message = message;
 if (level)
 this.level = level;
 else
 this.level = 'info';

 this.notify = function () {
 $.UIkit.notify({
 message: this.level + ': ' + this.type + ' ' + this.message,
 status: 'info',
 timeout: 5000,
 pos: 'bottom-left'
 });
 }
 }*/

/*function LocalStorageArray(id) {
 if (typeof (sessionStorage) === 'undefined') {
 // Sorry! No Web Storage support..
 return ['speed']; // TODO: fetch this array from backend DB rather than keeping as in-memory array
 }
 if (id === undefined) {
 throw 'Should provide an id to create a local storage!';
 }
 var DELIMITER = ','; // Private variable delimiter
 this.storageId = id;
 sessionStorage.setItem(id, 'speed'); // TODO: <note> even tho we use `sessionStorage` because of this line previous it get overwritten in each page refresh
 this.getArray = function () {
 return sessionStorage.getItem(this.storageId).split(DELIMITER);
 };

 this.length = this.getArray().length;

 this.push = function (value) {
 var currentStorageValue = sessionStorage.getItem(this.storageId);
 var updatedStorageValue;
 if (currentStorageValue === null) {
 updatedStorageValue = value;
 } else {
 updatedStorageValue = currentStorageValue + DELIMITER + value;
 }
 sessionStorage.setItem(this.storageId, updatedStorageValue);
 this.length += 1;
 };
 this.isEmpty = function () {
 return (this.getArray().length === 0);
 };
 this.splice = function (index, howmany) {
 var currentArray = this.getArray();
 currentArray.splice(index, howmany);
 var updatedStorageValue = currentArray.toString();
 sessionStorage.setItem(this.storageId, updatedStorageValue);
 this.length -= howmany;
 // TODO: should return spliced section as array
 };
 }*/
/*------------------------------ Helper methods --end ------------------------------*/

/*------------------------------ Order dispatch view manipulations ------------------------------*/
var notDispatchedOrders = [];
function addToNotDispatch(order) {


    if (order.refId in notDispatchedOrders) { // TODO: actual value properties.cabId
        console.log("DEBUG: order.refId in +" + order.refId);
        var excitingOrder = notDispatchedOrders[order.refId];
        console.log("DEBUG: Need to handle this seperately");
    }
    else {
        console.log("DEBUG: order.refId not in =" + order.refId);
        var newOrder = new Order(order);
        newOrder.addToMonitorBoard();
        $.UIkit.notify({
            message: "new order " + order.refId + " added.",
            status: 'success',
            timeout: waitTime,
            pos: 'top-center'
        });
        notDispatchedOrders[newOrder.id] = newOrder;
    }

}


function addToMsgNotCopied(order) {
    removeOrderFromMonitor(order);
    var newOrder = new Order(order);
    newOrder.addToMonitorBoard();
    $.UIkit.notify({
        message: "new order " + order.refId + " added.",
        status: 'success',
        timeout: waitTime,
        pos: 'top-center'
    });

}

function removeOrderFromMonitor(order) {
    $.UIkit.notify({
        message: "Order " + order.refId + " canceled by the customer",
        status: 'danger',
        timeout: waitTime,
        pos: 'top-center'
    });
    delete notDispatchedOrders[order.refId];
    $('#START > tbody').find('#' + order.refId).fadeOut().remove();
}

/*----------------------- Order Object Definition -----------------------*/

function Order(orderJson) {
    this.orderJson = orderJson; // For reference

    this.refId = orderJson.refId; // actual ID is this.id
    this.id = this.refId;
    this.driver = {id: orderJson.driverId};
    this.status = orderJson.status;
    this.address = orderJson.address;
    this.bookTime = orderJson.bookTime;
    this.croId = orderJson.croId;
    if (typeof orderJson.cro != 'undefined') {
        this.croName = orderJson.cro.name;
    }
    this.cabId = orderJson.cabId;
    this.isTinted = orderJson.isTinted;
    this.isUnmarked = orderJson.isUnmarked;
    this.isVip = orderJson.isVip;
    this.isVih = orderJson.isVih;

    return this;
}


/*----- Override JSON method toString() -----*/
Order.prototype.addressToString = function () {
    var addressString = "";
    for (var addressComponent in this.address) {
        if (this.address.hasOwnProperty(addressComponent)) {
            addressString += this.address[addressComponent] + ', ';
        }
    }
    return addressString;
};

Order.prototype.getBadge = function (status) {
    var returnBadge;
    if (status) {
        returnBadge = '<span class="badge alert-info"><span style="color: #5cb85c" class="glyphicon glyphicon-ok"></span></span>';
    } else {
        returnBadge = '<span class="badge alert-warning"><span style="color: #d9534f" class="glyphicon glyphicon-remove"></span></span>';
    }
    return returnBadge;
};

Order.prototype.createOrderDOM = function () {
    var currentTime = moment();
    switch (this.status) {
        case "START":
            return ("<tr id=\"" + this.id + "\">" +
            '<td>' + this.id + '</td>' +
            '<td>' + currentTime.format('Do-MMM-YY  hh:mm a') + '</td>' +
            '<td>' + 'N/A' + '</td>' +
            '<td>' + this.addressToString() + '</td>' +
            '<td>' + this.croId + '</td>' +
            '<td>' + 'N/A' + '</td>' +
            '<td>' + 'N/A' + '</td>' +
                /*DIM*/
            '<td>' + this.getBadge(false) + '</td>' +
                /*VIH*/
            '<td>' + this.getBadge(this.isVih) + '</td>' +
                /*VIP*/
            '<td>' + this.getBadge(this.isVip) + '</td>' +
                /*COP*/
            '<td>' + this.getBadge(false) + '</td>' +
            '</tr>');
        case "MSG_NOT_COPIED":
            return ("<tr id=\"" + this.id + "\">" +
            '<td>' + this.id + '</td>' +
            '<td>' + moment.unix(this.orderJson.callTime.sec).format('Do-MMM-YY  hh:mm a') + '</td>' +
            '<td>' + currentTime.format('Do-MMM-YY  hh:mm a') + '</td>' +
            '<td>' + this.cabId + '</td>' +
            '<td>' + this.orderJson.driverTp + '</td>' +
            '<td>' + this.addressToString() + '</td>' +
            '<td>' + this.croName + '(' + this.croId + ')' + '</td>' +
                /*DIM*/
            '<td>' + this.getBadge(false) + '</td>' +
                /*VIH*/
            '<td>' + this.getBadge(this.isVih) + '</td>' +
                /*VIP*/
            '<td>' + this.getBadge(this.isVip) + '</td>' +
                /*COP*/
            '<td>' + this.getBadge(false) + '</td>' +
            '</tr>');
    }
};


Order.prototype.addToMonitorBoard = function () {
    this.orderDOM = this.createOrderDOM();
    $('#' + this.status + ' > tbody:last').append(this.orderDOM);
};
