/**
 * Created by dehan on 11/1/14.
 */
//Models
var test2=[
    {"cab":{"_id":{"$id":"544915126b648683578b4569"},"model":"nano","color":"red","plateNo":"GA-45852","vType":"Nano","info":"Other","cabId":1,"zone":"Nawaloka"}},
    {"cab":{"_id":{"$id":"5455c0746b6486251ae31e24"},"model":"toyota","color":"red","plateNo":"km-46569","vType":"car","info":"dam cab","cabId":2,"zone":"Nawala"}},
    {"cab":{"_id":{"$id":"5455fb40e1074dcd0d377af4"},"model":"Honda","color":"green","plateNo":"km-48964","vType":"car","info":"Testing cab","cabId":12,"zone":"Rajagiriya"}}];
var test = [{
                "model":"nano",
                "color":"red",
                "plateNo":"GA-45852",
                "vType":"vehicle_type_demo",
                "info":"Other",
                "cabId":1,
                "zone":"Fort"


            },
            {
                "model":"toyota",
                "color":"red",
                "plateNo":"km-46569",
                "vType":"car",
                "info":"dam cab",
                "cabId":2,
                "zone":"Nawaloka"
            },
            {
                "model":"Honda",
                "color":"green",
                "plateNo":"km-48964",
                "vType":"car",
                "info":"Testing cab",
                "cabId":12,
                "zone":"Nawaloka"

            }];
var LocationBoard = {};
LocationBoard.zones = [];
LocationBoard.other = [];

LocationBoard.pending = [];
LocationBoard.pob = [];

var GlobalCabs = [];
var currentDispatchOrderRefId = 12341234;

var user1 = {};
user1.id = 9900;
user1.Name = "Chithral Somapala";
user1.userName =  "Chitty";

var user2 = {};
user2.id = 9901;
user2.Name = "Kasun Kalhara";
user2.userName =  "Chitty";

var user3 = {};
user3.id = 9902;
user3.Name = "Sunil Edirisinge";
user3.userName =  "Chitty";

var user4 = {};
user4.id = 9903;
user4.Name = "Namal Rajapakse";
user4.userName =  "Chitty";

var user5 = {};
user5.id = 9904;
user5.Name = "Chithral Somapala";
user5.userName =  "Chitty";

var user6 = {};
user6.id = 9905;
user6.Name = "Kasun Kalhara";
user6.userName =  "Chitty";

var user7 = {};
user7.id = 9906;
user7.Name = "Sunil Edirisinge";
user7.userName =  "Chitty";

var user8 = {};
user8.id = 9907;
user8.Name = "Namal Rajapakse";
user8.userName =  "Chitty";

var cab1 ={};
cab1.id = 1001;
cab1.attributes = {};
cab1.currentDriver = user1;
cab1.vehicleType = "Van";
cab1.attributes.vehicleColor = "Black";
cab1.attributes.isTinted = "Yes";
cab1.attributes.isMarked = "Yes";
cab1.attributes.model = "Toyota Corolla";
cab1.isDriverIdle = "false";
cab1.currentLocation = "23,Kotta Road, Borella";

var cab2 ={};
cab2.id = 1002;
cab2.attributes = {};
cab2.currentDriver = user2;
cab2.vehicleType = "Car";
cab2.attributes.vehicleColor = "Black";
cab2.attributes.isTinted = "Yes";
cab2.attributes.isMarked = "Yes";
cab2.attributes.model = "Toyota Corolla";
cab2.isDriverIdle = "false";
cab2.currentLocation = "23,Kotta Road, Borella";


var cab3 ={};
cab3.id = 1003;
cab3.attributes = {};
cab3.currentDriver = user3;
cab3. vehicleType = "Car";
cab3.attributes.vehicleColor = "Black";
cab3.attributes.isTinted = "Yes";
cab3.attributes.isMarked = "Yes";
cab3.attributes.model = "Toyota Corolla";
cab3.isDriverIdle = "false";
cab3.currentLocation = "23,Kotta Road, Borella";

var cab4 ={};
cab4.id = 1004;
cab4.attributes = {};
cab4.currentDriver = user4;
cab4. vehicleType = "Van";
cab4.attributes.vehicleColor = "Black";
cab4.attributes.isTinted = "Yes";
cab4.attributes.isMarked = "Yes";
cab4.attributes.model = "Toyota Corolla";
cab4.isDriverIdle = "false";
cab4.currentLocation = "23,Kotta Road, Borella";

var cab5 ={};
cab5.id                         = 1005;
cab5.attributes                 = {};
cab5.currentDriver              = user5;
cab5. vehicleType               = "Nano";
cab5.attributes.vehicleColor    = "Black";
cab5.attributes.isTinted        = "Yes";
cab5.attributes.isMarked        = "Yes";
cab5.attributes.model           = "Toyota Corolla";
cab5.isDriverIdle               = "false";
cab5.currentLocation            = "23,Kotta Road, Borella";

cab6 ={};
cab6.id = 1006;
cab6.attributes = {};
cab6.currentDriver = user6;
cab6.vehicleType = "Van";
cab6.attributes.vehicleColor = "Black";
cab6.attributes.isTinted = "Yes";
cab6.attributes.isMarked = "Yes";
cab6.attributes.model = "Toyota Corolla";
cab6.isDriverIdle = "false";
cab6.currentLocation = "23,Kotta Road, Borella";

var cab7 ={};
cab7.id = 1007;
cab7.attributes = {};
cab7.currentDriver = user7;
cab7.vehicleType = "Nano";
cab7.attributes.vehicleColor = "Black";
cab7.attributes.isTinted = "Yes";
cab7.attributes.isMarked = "Yes";
cab7.attributes.model = "Toyota Corolla";
cab7.isDriverIdle = "false";
cab7.currentLocation = "23,Kotta Road, Borella";

var cab8 ={};
cab8.id = 1008;
cab8.attributes = {};
cab8.currentDriver = user8;
cab8.vehicleType = "Nano";
cab8.attributes.vehicleColor = "Black";
cab8.attributes.isTinted = "Yes";
cab8.attributes.isMarked = "Yes";
cab8.attributes.model = "Toyota Corolla";
cab8.isDriverIdle = "No";
cab8.currentLocation = "23,Kotta Road, Borella";


GlobalCabs.push(cab1);
GlobalCabs.push(cab2);
GlobalCabs.push(cab3);
GlobalCabs.push(cab4);
GlobalCabs.push(cab5);
GlobalCabs.push(cab6);
GlobalCabs.push(cab7);
GlobalCabs.push(cab8);



function Zone(id, name){
    this.id = id;
    this.name           = name;
    this.idle               = {};
    this.idle.driverId      = ko.observable();
    this.idle.cabs          = ko.observableArray([]);


    this.pob                = {};
    this.pob.driverId       = ko.observable();
    this.pob.cabEta         = ko.observable();
    this.pob.cabs           = ko.observableArray([]);
}

function Inactive(id, name){
    this.id = id;
    this.name = name;
    this.driverId = ko.observable();
    this.cabs = ko.observable([]);
}

function Cab(data){
    this.id                         =  data.cabId;
    this.attributes                 =  {};
    this.driverId                   =  data.driverId;
    this.attributes.model           =  data.model;
    this.attributes.vehicleColor    =  data.color;
    this.vehicleType                =  data.vType;
    this.info                       =  data.info;
    this.zone                       =  data.zone;
    this.state                      =  data.state;
    this.eta                        =  data.eta;
}


var zone1   = new Zone( 1,"Fort");
var zone2   = new Zone( 2,"Nawaloka");
var zone3   = new Zone( 3,"Colombo 03");
var zone4   = new Zone( 4,"Marinedrive 03");
var zone5   = new Zone( 5,"Colombo 04");
var zone6   = new Zone( 6,"Marinedrive 04");
var zone7   = new Zone( 7,"T'Mulla/Thimbiri");
var zone8   = new Zone( 8,"Vilasitha(Kirulapona)");
var zone9   = new Zone( 9,"Colombo 06");
var zone10  = new Zone(10,"Marinedrive 04");

var zone11  = new Zone(11,"Alex"                    );
var zone12  = new Zone(12,"Rupavahing"              );
var zone13  = new Zone(13,"Borella"                 );
var zone14  = new Zone(14,"Narahenpita"             );
var zone15  = new Zone(15,"Nawala"                  );
var zone16  = new Zone(16,"Rajagiriya"              );
var zone17  = new Zone(17,"Kotte"                   );
var zone18  = new Zone(18,"Battaramulla"            );
var zone19  = new Zone(19,"Malabe"                  );
var zone20  = new Zone(20,"Kottawa"                 );
var zone21  = new Zone(21,"Maharagama"              );
var zone22  = new Zone(22,"Nugegoda"                );
var zone23  = new Zone(23,"Piliyandala"             );
var zone24  = new Zone(24,"Boralesgamuwa"           );
var zone25  = new Zone(25,"Kohuvala"                );
var zone26  = new Zone(26,"Kalubovila"              );
var zone27  = new Zone(27,"Dehivala"                );
var zone28  = new Zone(28,"Mount Lavinia"           );

var zone29  = new Zone(29,"Rathmalana"                  );
var zone30  = new Zone(30,"Moratuwa"              );
var zone31  = new Zone(31,"Panadura"                   );
var zone32  = new Zone(32,"Dematagoda"            );
var zone33  = new Zone(33,"Piliyandala"                  );
var zone34  = new Zone(34,"Wattala"                 );
var zone35  = new Zone(35,"Kiribathgoda"              );
var zone36  = new Zone(36,"Ja-Ela"                );
var zone37  = new Zone(37,"Kadawatha"             );
var zone38  = new Zone(38,"Seeduwa"           );
var zone39  = new Zone(39,"KIA"                );
var zone40  = new Zone(40,"Negombo"              );


var other1  = new Other(41,"Outstation"               );
var other2  = new Other(42,"Writing Hire"              );
var other3  = new Other(43,"Package"                   );
var other4  = new Other(44,"Corporate"            );
var other5  = new Other(45,"Lunch and Tea"                  );
var other6  = new Other(46,"Break Down"                 );
var other7  = new Other(47,"Not Reported"              );
var other8  = new Other(48,"Leave"                );
var other9  = new Other(48,"Unknown"                );
//zone1.idle.cabs.push(cb1)
//zone1.idle.cabs.push(cab4);
//zone1.idle.cabs.push(cab5);
//zone1.idle.cabs.push(cab6);
//zone1.idle.cabs.push(cab7);
//zone2.idle.cabs.push(cab2);
//zone3.idle.cabs.push(cab3);
//zone4.idle.cabs.push(cab4);

LocationBoard.zones.push(zone1 );
LocationBoard.zones.push(zone2 );
LocationBoard.zones.push(zone3 );
LocationBoard.zones.push(zone4 );
LocationBoard.zones.push(zone5 );
LocationBoard.zones.push(zone6 );
LocationBoard.zones.push(zone7 );
LocationBoard.zones.push(zone8 );
LocationBoard.zones.push(zone9 );
LocationBoard.zones.push(zone10);

LocationBoard.zones.push(zone11);
LocationBoard.zones.push(zone12);
LocationBoard.zones.push(zone13);
LocationBoard.zones.push(zone14);
LocationBoard.zones.push(zone15);
LocationBoard.zones.push(zone16);
LocationBoard.zones.push(zone17);
LocationBoard.zones.push(zone18);
LocationBoard.zones.push(zone19);
LocationBoard.zones.push(zone20);

LocationBoard.zones.push(zone21);
LocationBoard.zones.push(zone22);
LocationBoard.zones.push(zone23);
LocationBoard.zones.push(zone24);
LocationBoard.zones.push(zone25);
LocationBoard.zones.push(zone26);
LocationBoard.zones.push(zone27);
LocationBoard.zones.push(zone28);
LocationBoard.zones.push(zone29);
LocationBoard.zones.push(zone30);

LocationBoard.zones.push(zone31);
LocationBoard.zones.push(zone32);


//====================================//

LocationBoard.zones.push(zone33);
LocationBoard.zones.push(zone34);
LocationBoard.zones.push(zone35);
LocationBoard.zones.push(zone36);
LocationBoard.zones.push(zone37);
LocationBoard.zones.push(zone38);
LocationBoard.zones.push(zone39);
LocationBoard.zones.push(zone40);


//Other Zones

LocationBoard.other.push(other1);
LocationBoard.other.push(other2);
LocationBoard.other.push(other3);
LocationBoard.other.push(other4);
LocationBoard.other.push(other5);
LocationBoard.other.push(other6);
LocationBoard.other.push(other7);
LocationBoard.other.push(other8);

//=================End Of Models======================//

//Global Variables
var currentActiveOrder = 12345678;

//==============ViewModel============================//

var baseUrl = ApplicationOptions.constance.BASE_URL;

var serviceUrl = baseUrl;
function LocationBoardViewModel(){
    var self = this;

    var zonesLength = LocationBoard.zones.length;



    self.zones = ko.observableArray(LocationBoard.zones);

    self.other = ko.observableArray(LocationBoard.other);

    self.pendingCabs = ko.observableArray([]);

    self.otherCabs = ko.observableArray([]);

    self.cabList = {};

    self.initializeLocationBoard = function(){
        self.responseCabs;
        $.ajax({
            url: serviceUrl + "dispatcher/cabsInZones",
            type: "GET",
            dataType: "json"
        }).done(function( response ) {

            self.cabListBuffer = $.map(response,function(item){
                return new Cab(item);
            });

            self.cabList = ko.observableArray(self.cabListBuffer);

            for(var key in self.cabList()){
                var currentCab = self.cabList()[key];
                if (currentCab.state === "IDLE" && currentCab.zone === "None") {
                    var otherObject = ko.utils.arrayFirst(LocationBoard.other, function(item) {
                        return item.name === "Unknown"
                    });
                    var index = ko.utils.arrayIndexOf(LocationBoard.other,otherObject);
                    if(index != -1){
                        self.other()[index].cabs.push(currentCab);

                    }
                }
                else if(currentCab.state === "OTHER" ){
                    var otherObject = ko.utils.arrayFirst(LocationBoard.other, function(item) {
                        return item.name === currentCab.zone
                    });
                    var index = ko.utils.arrayIndexOf(LocationBoard.other,otherObject);
                    if(index != -1){
                        self.other()[index].cabs.push(currentCab);

                    }
                }
                else if(currentCab.state === "MSG_NOT_COPIED" || currentCab.state === "MSG_COPIED"|| currentCab.state === "AT_THE_PLACE") {
                    self.pendingCabs.push(currentCab);

                }
                else{
                    var zoneObject = ko.utils.arrayFirst(LocationBoard.zones, function(item) {
                        return item.name === currentCab.zone
                    });
                    var index = ko.utils.arrayIndexOf(LocationBoard.zones,zoneObject);
                    if(index != -1){
                        if(currentCab.state == "IDLE"){
                            self.zones()[index]["idle"].cabs.push(currentCab);
                        }
                        else if(currentCab.state == "POB"){
                            self.zones()[index]["pob"].cabs.push(currentCab);
                        }
                    }
                }

            }
        }).fail(function( jqXHR, textStatus ) {
            console.log( "Location Board Init failed: " + textStatus );
        });
    };

    var zonesRange1 = self.zones.slice(0,Math.round(zonesLength/2));
    var zonesRange2 = self.zones.slice(Math.round(zonesLength/2),zonesLength);

    self.ZonesColumn1 = ko.computed(function() {
        var zoneList = LocationBoard.zones.slice(0,Math.round(zonesLength/2));
        return zoneList;
    });

    self.ZonesColumn2 = ko.computed(function() {
        var zoneList = LocationBoard.zones.slice(Math.round(zonesLength/2),zonesLength);
        return zoneList;
    });




    self.PobZonesColumn1 = ko.computed(function() {
        var zoneList = LocationBoard.zones.slice(0,Math.round(zonesLength/2));
        return zoneList;
    });

    self.PobZonesColumn2 = ko.computed(function() {
        var zoneList = LocationBoard.zones.slice(Math.round(zonesLength/2),zonesLength);
        return zoneList;
    });




    self.OtherColumn1 = ko.computed(function() {
        var zoneList = LocationBoard.other.slice(0,Math.round(zonesLength/2));
        return zoneList;
    });

    self.OtherColumn2 = ko.computed(function() {
        var zoneList = LocationBoard.other.slice(Math.round(zonesLength/2),zonesLength);
        return zoneList;
    });



    self.addIdleCab = function(zone,event){

        cabId = parseInt(zone.idle.driverId());
        zone.idle.driverId('');


        sendingData = {};
        sendingData.driverId = cabId;
        sendingData.zone = zone.name;

        var gotResponse = null;
        $.post(serviceUrl +"dispatcher/setIdleZone",sendingData,function(response){
            gotResponse = response;
            gotResponse.state = "IDLE";
            var currentCab = new Cab(gotResponse);

            var lastZone = response.lastZone;

            if(gotResponse !== null || gotResponse.driver !== null){


                //Remove from last zone and all other places
                var zoneObjectToRemove = ko.utils.arrayFirst(LocationBoard.zones, function(item) {
                    return item.name === lastZone
                });
                var indexToRemove = ko.utils.arrayIndexOf(LocationBoard.zones,zoneObjectToRemove);
                //If cab was not inactive [when inactive, state = IDLE, zone = null]
                if(indexToRemove != -1){
                    self.zones()[indexToRemove].idle.cabs.remove(function(item) { return item.id === currentCab.id });
                    self.zones()[indexToRemove].pob.cabs.remove(function(item) { return item.id === currentCab.id });
                }
                self.pendingCabs.remove(function(item) { return item.id === currentCab.id });
                //Remove from other
                var otherObject = ko.utils.arrayFirst(LocationBoard.other, function(item) {
                    return item.name === currentCab.zone
                });
                var otherIndexToRemove = ko.utils.arrayIndexOf(LocationBoard.other,otherObject);
                if(otherIndexToRemove != -1){
                    self.other()[otherIndexToRemove].cabs.remove(function(item) { return item.id === currentCab.id });
                }


                //Add to new zone
                var zoneObjectToAdd = ko.utils.arrayFirst(LocationBoard.zones, function(item) {
                    return item.name === currentCab.zone
                });
                var indexToAdd = ko.utils.arrayIndexOf(LocationBoard.zones,zoneObjectToAdd);
                if(indexToAdd !== -1){
                    self.zones()[indexToAdd].idle.cabs.push(currentCab);
                }
                else{
                    alert("Unknown Error, Zone is undefined");
                }

            }
            else{
                alert('Cab Id does not exist');
            }

            $.UIkit.notify({
                message: '<span style="color: dodgerblue">' + response.status + '</span><br>' + response.message,
                status: (response.status == 'success' ? 'success' : 'danger'),
                timeout: 3000,
                pos: 'top-center'
            });
        });




    };

    self.addPobCab = function(zone,event){

        sendingData = {};
        sendingData.driverId = parseInt(zone.pob.driverId());
        sendingData.cabEta = zone.pob.cabEta();
        sendingData.zone = zone.name;

        zone.pob.cabEta('');
        zone.pob.driverId('');
        $.post('dispatcher/setPobDestinationZoneTime', sendingData, function (response) {
            gotResponse = response;
            gotResponse.state = "POB";
            var lastZone = response.lastZone;
            var currentCab = new Cab(gotResponse);

            //Remove from all last zones and all other places
            var zoneObjectToRemove = ko.utils.arrayFirst(LocationBoard.zones, function(item) {
                return item.name === lastZone
            });
            var indexToRemove = ko.utils.arrayIndexOf(LocationBoard.zones,zoneObjectToRemove);
            //If cab was not inactive [when inactive, state = IDLE, zone = null]
            if(indexToRemove != -1){
                self.zones()[indexToRemove].idle.cabs.remove(function(item) { return item.id === currentCab.id });
                self.zones()[indexToRemove].pob.cabs.remove(function(item) { return item.id === currentCab.id });
            }
            self.pendingCabs.remove(function(item) { return item.id === currentCab.id });
            //Remove from other
            var otherObject = ko.utils.arrayFirst(LocationBoard.other, function(item) {
                return item.name === currentCab.zone
            });
            var otherIndexToRemove = ko.utils.arrayIndexOf(LocationBoard.other,otherObject);
            if(otherIndexToRemove != -1){
                self.other()[otherIndexToRemove].cabs.remove(function(item) { return item.id === currentCab.id });
            }




            //Add to new zone
            var zoneObjectToAdd = ko.utils.arrayFirst(LocationBoard.zones, function(item) {
                return item.name === currentCab.zone
            });
            var indexToAdd = ko.utils.arrayIndexOf(LocationBoard.zones,zoneObjectToAdd);
            if(indexToAdd !== -1){
                self.zones()[indexToAdd].pob.cabs.push(currentCab);
            }


        });

    };

    self.addOtherCab = function(inactive,event){

        sendingData = {};
        sendingData.driverId = parseInt(inactive.driverId());
        sendingData.zone = inactive.name;

        zone.pob.cabEta('');
        zone.pob.driverId('');
        $.post('dispatcher/setOtherState', sendingData, function (response) {
            gotResponse = response;
            gotResponse.state = "OTHER";
            var lastZone = response.lastZone;
            var currentCab = new Cab(gotResponse);

            //Remove from all last zones and all other places
            var zoneObjectToRemove = ko.utils.arrayFirst(LocationBoard.zones, function(item) {
                return item.name === lastZone
            });
            var indexToRemove = ko.utils.arrayIndexOf(LocationBoard.zones,zoneObjectToRemove);
            //If cab was not inactive [when inactive, state = IDLE, zone = null]
            if(indexToRemove != -1){
                self.zones()[indexToRemove].idle.cabs.remove(function(item) { return item.id === currentCab.id });
                self.zones()[indexToRemove].pob.cabs.remove(function(item) { return item.id === currentCab.id });
            }
            self.pendingCabs.remove(function(item) { return item.id === currentCab.id });

            //Remove from other
            var otherObject = ko.utils.arrayFirst(LocationBoard.other, function(item) {
                return item.name === currentCab.zone
            });
            var otherIndexToRemove = ko.utils.arrayIndexOf(LocationBoard.other,otherObject);
            if(otherIndexToRemove != -1){
                self.other()[otherIndexToRemove].cabs.remove(function(item) { return item.id === currentCab.id });
            }


            //Add to new zone
            var otherObjectToAdd = ko.utils.arrayFirst(LocationBoard.other, function(item) {
                return item.name === currentCab.zone
            });
            var indexToAdd = ko.utils.arrayIndexOf(LocationBoard.zones,otherObjectToAdd);
            if(indexToAdd !== -1){
                self.other()[indexToAdd].cabs.push(currentCab);
            }


        });

    };

    self.dispatchCab = function(zone, cab){
        $.UIkit.notify.closeAll();
        var dispatchNotify = $.UIkit.notify({
            message: '<span style="color: dodgerblue">Dispatching order <b>'+currentDispatchOrderRefId+'</b></span>',
            status: 'warning',
            timeout: 0,
            pos: 'top-center'
        });

        sendingData = {};
        sendingData.cabId = cab.id;
        sendingData.orderId = currentDispatchOrderRefId;
        $.post('dispatcher/dispatchVehicle', sendingData, function (response) {
            console.log(response);
            setTimeout(function(){dispatchNotify.close()},3000);
            dispatchNotify.status('success');
            dispatchNotify.content("Order Dispatched successfully!");
            console.log(response);
            currentDispatchOrderRefId = null;
            var orderDOM = $('#liveOrdersList').find('#' + sendingData.orderId);
            $(orderDOM).fadeOut();
            orderDOM.appendTo('#dispatchedOrdersList .mCSB_container');
            $('#liveOrdersList').find('#' + sendingData.orderId).remove();
            setTimeout(function(){orderDOM.show()},500);
            cab.state = "MSG_NOT_COPIED";
            zone.idle.cabs.remove(cab);
            self.pendingCabs.push(cab);
        });

    };

    self.removeCabFromPending = function(vm,cab){
        sendingData = {};
        sendingData.cabId = cab.id;
        $.post(serviceUrl +"dispatcher/setInactive",sendingData,function(response){
            self.pendingCabs.remove(cab);
            cab.state = "IDLE";
            cab.zone = "None";
            self.inactiveCabs.push(cab);
        });


    };

    self.removeCabFromPob = function(zone, cab){
        sendingData = {};
        sendingData.cabId = cab.id;
        $.post(serviceUrl +"dispatcher/setInactive",sendingData,function(response){
            zone.pob.cabs.remove(cab);
            cab.state = "IDLE";
            cab.zone = "None";
            //Remove from other
            var otherObject = ko.utils.arrayFirst(LocationBoard.other, function(item) {
                return item.name === currentCab.zone
            });
            var otherIndexToRemove = ko.utils.arrayIndexOf(LocationBoard.other,otherObject);
            if(otherIndexToRemove != -1){
                self.other()[otherIndexToRemove].cabs.remove(function(item) { return item.id === currentCab.id });
            }

        });


    };

    // To set from pob to live automatically
    self.setToIdleFromPob = function(zone,cab){

        sendingData = {};
        sendingData.driverId = cab.driverId;
        sendingData.zone = zone.name;
        $.post(serviceUrl +"dispatcher/setIdleZone",sendingData,function(response){
            zone.pob.cabs.remove(cab);
            gotResponse = response;

            var currentCab = new Cab(gotResponse);

            var lastZone = response.lastZone;

            if(gotResponse !== null || gotResponse.driver !== null){


                //Remove from last zone and all other places
                var zoneObjectToRemove = ko.utils.arrayFirst(LocationBoard.zones, function(item) {
                    return item.name === lastZone
                });
                var indexToRemove = ko.utils.arrayIndexOf(LocationBoard.zones,zoneObjectToRemove);
                //If cab was not inactive [when inactive, state = IDLE, zone = null]
                if(indexToRemove != -1){
                    self.zones()[indexToRemove].idle.cabs.remove(function(item) { return item.id === currentCab.id });
                    self.zones()[indexToRemove].pob.cabs.remove(function(item) { return item.id === currentCab.id });
                }
                self.pendingCabs.remove(function(item) { return item.id === currentCab.id });
                //Remove from other
                var otherObject = ko.utils.arrayFirst(LocationBoard.other, function(item) {
                    return item.name === currentCab.zone
                });
                var otherIndexToRemove = ko.utils.arrayIndexOf(LocationBoard.other,otherObject);
                if(otherIndexToRemove != -1){
                    self.other()[otherIndexToRemove].cabs.remove(function(item) { return item.id === currentCab.id });
                }



                //Add to new Idle zone
                var zoneObjectToAdd = ko.utils.arrayFirst(LocationBoard.zones, function(item) {
                    return item.name === currentCab.zone
                });
                var indexToAdd = ko.utils.arrayIndexOf(LocationBoard.zones,zoneObjectToAdd);
                if(indexToAdd !== -1){
                    self.zones()[indexToAdd].idle.cabs.push(currentCab);
                }
                else{
                    alert("Unknown Error, Zone is undefined");
                }

            }
            else{
                alert('Cab Id does not exist');
            }

            $.UIkit.notify({
                message: '<span style="color: dodgerblue">' + response.status + '</span><br>' + response.message,
                status: (response.status == 'success' ? 'success' : 'danger'),
                timeout: 3000,
                pos: 'top-center'
            });
        });
        console.log("Setting to Idle not fully implemented");
        
        

    }
    self.disableInputs = function () {
        $('button.cabAdd').css('display','none');
        $('button.cabManipulate').css('display','none');

        $('span.add-on').css('display','none');
        $('input').css('display','none')
    }





}
var locVM = new LocationBoardViewModel();
locVM.initializeLocationBoard();
ko.applyBindings(locVM);

