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

LocationBoard.pending = [];
LocationBoard.pob = [];
LocationBoard.Unknown = [];

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
    this.live               = {};
    this.live.cabInput      = ko.observable();
    this.live.cabs          = ko.observableArray([]);

    this.pending            = {};
    this.pending.cabInput   = ko.observable();
    this.pending.cabs       = ko.observableArray([]);


    this.pob                = {};
    this.pob.cabInput       = ko.observable();
    this.pob.cabs           = ko.observableArray([]);


}

function Cab(data){
    this.id                         =  data.cabId;
    this.attributes                 =  {};
    this.currentDriver              =  {};
    this.attributes.model           =  data.model;
    this.attributes.vehicleColor    =  data.color;
    this.vehicleType                =  data.vType;
    this.info                       =  data.info;
    this.zone                       =  data.zone;
    this.state                      =  "live";
}


var zone1   = new Zone( 1,"Fort");
var zone2   = new Zone( 2,"Nawaloka");
var zone3   = new Zone( 3,"Colombo 03");
var zone4   = new Zone( 4,"Marinedrive 03");
var zone5   = new Zone( 5,"Colombo 04");
var zone6   = new Zone( 6,"Marinedrive 04");
var zone7   = new Zone( 7,"T'Malla/COLOS");
var zone8   = new Zone( 8,"Vilasitha(Kirulapona)");
var zone9   = new Zone( 9,"Colombo 04");
var zone10  = new Zone(10,"Marinedrive 04");

var zone11  = new Zone(11,"T'Malla/COLOS");
var zone12  = new Zone(12,"Vilasitha(Kirulapona)");
var zone13  = new Zone(13,"Colombo 06");
var zone14  = new Zone(14,"Marinedrive 06");
var zone15  = new Zone(15,"Alex");
var zone16  = new Zone(16,"Rupavahing");
var zone17  = new Zone(17,"Borella");
var zone18  = new Zone(18,"Narahenpita");
var zone19  = new Zone(19,"Nawala");
var zone20  = new Zone(20,"Rajagiriya");

var zone21  = new Zone(21,"Kotte");
var zone22  = new Zone(22,"Battaramulla");
var zone23  = new Zone(23,"Malabe");
var zone24  = new Zone(24,"Kottawa");
var zone25  = new Zone(25,"Maharagama");
var zone26  = new Zone(26,"Nugegoda");
var zone27  = new Zone(27,"Piliyandala");
var zone28  = new Zone(28,"Boralesgamuwa");
var zone29  = new Zone(29,"Kohuvala");
var zone30  = new Zone(30,"Kalubovila");

var zone31  = new Zone(31,"Dehivala");
var zone32  = new Zone(32,"Mount Lavinia");






//zone1.live.cabs.push(cab1);
//zone1.live.cabs.push(cab4);
//zone1.live.cabs.push(cab5);
//zone1.live.cabs.push(cab6);
//zone1.live.cabs.push(cab7);
//zone2.live.cabs.push(cab2);
//zone3.live.cabs.push(cab3);
//zone4.live.cabs.push(cab4);

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
                var zoneObject = ko.utils.arrayFirst(LocationBoard.zones, function(item) {
                    return item.name === currentCab.zone
                });
                var index = ko.utils.arrayIndexOf(LocationBoard.zones,zoneObject);
                if(index != -1){
                    if(currentCab.state == "live"){
                        self.zones()[index]["live"].cabs.push(currentCab);
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
        return zoneList
    });

    self.ZonesColumn2 = ko.computed(function() {
        var zoneList = LocationBoard.zones.slice(Math.round(zonesLength/2),zonesLength);
        return zoneList
    });



    self.addLiveCab = function(zone,event){

        cabId = parseInt(zone.live.cabInput());

        sendingData = {};
        sendingData.driverId = cabId;
        sendingData.zone = zone.name;

        var gotResponse = null;
        $.post(serviceUrl +"dispatcher/setZone",sendingData,function(response){
            gotResponse = response;

            if(gotResponse !== null || gotResponse.driver !== null){

                var currentCab = new Cab(gotResponse);
                var zoneObject = ko.utils.arrayFirst(LocationBoard.zones, function(item) {
                    return item.name === currentCab.zone
                });
                var index = ko.utils.arrayIndexOf(LocationBoard.zones,zoneObject);
                if(index !== -1){
                    self.zones()[index].live.cabs.push(currentCab);
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

    self.dispatchCab = function(zone, cab){
        sendingData = {};
        sendingData.cabId = cab.id;
        sendingData.orderId = currentDispatchOrderRefId;
        $.post('dispatcher/dispatchVehicle', sendingData, function (response) {
            console.log(response);
            $.UIkit.notify({
                message: '<span style="color: dodgerblue">' + response.status + '</span><br>' + response.message,
                status: (response.status == 'success' ? 'success' : 'danger'),
                timeout: 3000,
                pos: 'top-center'
            });
            currentDispatchOrderRefId = null;
            zone.live.cabs.remove(cab);
        });

    }




}
var locVM = new LocationBoardViewModel();
locVM.initializeLocationBoard();
ko.applyBindings(locVM);

