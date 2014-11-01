/**
 * Created by dehan on 11/1/14.
 */
//Models
var LocationBoard = {};
LocationBoard.zones = [];
var GlobalCabs = [];


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
cab5.id = 1005;
cab5.attributes = {};
cab5.currentDriver = user5;
cab5. vehicleType = "Nano";
cab5.attributes.vehicleColor = "Black";
cab5.attributes.isTinted = "Yes";
cab5.attributes.isMarked = "Yes";
cab5.attributes.model = "Toyota Corolla";
cab5.isDriverIdle = "false";
cab5.currentLocation = "23,Kotta Road, Borella";

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
cab8. vehicleType = "Nano";
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


var zone1 = {};
zone1.id = 1;
zone1.cabInput = ko.observable();
zone1.name = "Nawaloka";
zone1.cabs = ko.observableArray([]);
zone1.cabs.push(cab1);
zone1.cabs.push(cab4);
zone1.cabs.push(cab5);
zone1.cabs.push(cab6);
zone1.cabs.push(cab7);

var zone2 = {};
zone2.id = 2;
zone2.cabInput = ko.observable();
zone2.name = "Rajagiriya";
zone2.cabs = ko.observableArray([]);
zone2.cabs.push(cab2);

var zone3 = {};
zone3.id = 3;
zone3.cabInput = ko.observable();
zone3.name = "Moratuwa";
zone3.cabs = ko.observableArray([]);
zone3.cabs.push(cab3);

var zone4 = {};
zone4.id = 4;
zone4.cabInput = ko.observable();
zone4.name = "Galle";
zone4.cabs = ko.observableArray([]);
zone4.cabs.push(cab4);

LocationBoard.zones.push(zone1);
LocationBoard.zones.push(zone2);
LocationBoard.zones.push(zone3);
LocationBoard.zones.push(zone4);



//=================End Of Models======================//

//Global Variables
var currentActiveOrder = 12345678;

//==============ViewModel============================//
function LocationBoardViewModel(){
    var self = this;

    var zonesLength = LocationBoard.zones.length;

    var zonesRange1 = LocationBoard.zones.slice(0,Math.round(zonesLength/2));
    var zonesRange2 = LocationBoard.zones.slice(Math.round(zonesLength/2),zonesLength);

    self.zones = ko.observableArray(LocationBoard.zones);

    self.ZonesColumn1 = ko.computed(function() {
        var zoneList = LocationBoard.zones.slice(0,Math.round(zonesLength/2));
        return zoneList
    });

    self.ZonesColumn2 = ko.computed(function() {
        var zoneList = LocationBoard.zones.slice(Math.round(zonesLength/2),zonesLength);
        return zoneList
    });



    self.addCab = function(zone,event){

        cabId = parseInt(zone.cabInput());

        var cabToBeAdded = ko.utils.arrayFirst(GlobalCabs, function(item) {
            return item.id === cabId
        });
        if(cabToBeAdded != null){
            zone.cabs.push(cabToBeAdded);
        }
        else{
            alert('Cab Id does not exist');
        }

        zone.cabInput('');


    }

    self.dispatchCab = function(zone, cab){
        zone.cabs.remove(cab);
    }




}
var locVM = new LocationBoardViewModel();
ko.applyBindings(locVM);

