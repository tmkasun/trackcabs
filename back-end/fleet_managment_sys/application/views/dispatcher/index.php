<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>H&aacute;o City Cabs System</title>

    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets/img/favicon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets/img/favicon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets/img/favicon-152.png">

    <link rel="icon" sizes="196x196" href="<?= base_url() ?>assets/img/favicon-196.png">
    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/img/favicon.ico">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/app.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    <!-- Leaflet styles -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/leaflet.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/L.Control.Locate.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/MarkerCluster.Default.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/leaflet_fullscreen/leaflet.fullscreen.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/leaflet/leaflet.draw.css"/>

    <link rel="stylesheet" href="<?= base_url() ?>assets/css/uikit/uikit.min.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/uikit/addons/uikit.addons.min.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery-ui.theme.min.css">

    <!-- C3 chart library styles-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/d3/c3.css">

    <script src="<?= base_url() ?>assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-ui.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>

    <!-- Leaflet plugins libries -->
    <script src="<?= base_url() ?>assets/js/leaflet/leaflet.js"></script>
    <script src="<?= base_url() ?>assets/js/leaflet/leaflet.markercluster.js"></script>
    <script src="<?= base_url() ?>assets/js/leaflet/L.Control.Locate.js"></script>
    <script src="<?= base_url() ?>assets/js/leaflet/leaflet.groupedlayercontrol.js"></script>
    <script src="<?= base_url() ?>assets/js/leaflet/Leaflet.fullscreen.min.js"></script>
    <script src="<?= base_url() ?>assets/js/leaflet/Marker.Rotate.js"></script>
    <script src="<?= base_url() ?>assets/js/leaflet/leaflet.draw.js"></script>

    <!-- TODO: for reference <Update lib or remove if not in use>: This `R`(RaphaelLayer: https://github.com/dynmeth/RaphaelLayer) library is dam buggy can't use it reliably -->
    <!--<script src="<?= base_url() ?>assets/js/leaflet/rlayer.js"></script>-->
    <!--<script src="<?= base_url() ?>assets/js/leaflet/raphael-min.js"></script>-->

    <script src="<?= base_url() ?>assets/js/typeahead.bundle.min.js"></script>


    <!-- C3 charting library using D3 core -->
    <script src="<?= base_url() ?>assets/js/d3/d3.min.js"></script>
    <script src="<?= base_url() ?>assets/js/d3/c3.min.js"></script>

    <!-- UIkit libraries -->
    <script src="<?= base_url() ?>assets/js/uikit/uikit.min.js"></script>
    <script src="<?= base_url() ?>assets/js/uikit/addons/notify.min.js"></script>

    <!-- autobahn websocket and WAMP -->
    <script src="<?= base_url() ?>assets/js/autobahn/autobahn.min.js"></script>

    <!-- Self javascript libraries (Order of the import is very important, changing the order might shadow some variables, append new script to bottom ) -->
    <!-- ** comment out below imports if using minimized wso2_geo.min library **  -->
    <script src="<?= base_url() ?>assets/js/application_options.js"></script>
    <script>
        setBaseURL('<?= base_url() ?>'); // TODO: use better method to set BASE_URL infact set all dynamic vars, in here order matters caz initializing applicatioOptions
        var webSocketURL = 'ws://localhost:9764/outputwebsocket/t/carbon.super/DefaultWebsocketOutputAdaptor/geoDataEndPoint'; // TODO: Get the server IP and port and other static information from the applicationOptions object
        ApplicationOptions.constance.WEB_SOCKET_URL = webSocketURL;

        function subscribe(userid){
            console.log("DEBUG: userid = "+userid);
            var conn = new ab.Session('ws://192.168.0.21:8080',
                function() {
                    conn.subscribe(userid, function(topic, data) {
                        // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                        alert('New Message published to user "' + topic + '" : ' + data.message);
                    });
                },
                function() {
                    console.warn('WebSocket connection closed');
                },
                {'skipSubprotocolCheck': true}
            );
        }
        subscribe('dispatcher1');

    </script>
    <script src="<?= base_url() ?>assets/js/websocket.js"></script>
    <script src="<?= base_url() ?>assets/js/geo_remote.js"></script>
    <script src="<?= base_url() ?>assets/js/geo_fencing.js"></script>
    <script src="<?= base_url() ?>assets/js/show_alert_in_map.js"></script>

    <!-- Combined and compiled JS with google closure compile-->
    <!--<script src="<?= base_url() ?>assets/js/wso2_geo/wso2_geo.min.js"></script>-->

    <style>
        /*
        TODO: Move this styles to separate CSS for clarity.
        */
        .navbar {
            background: rgba(1, 32, 0, 0.80) none repeat scroll 0% 0%;
            color: rgba(0, 0, 0, 0.8);
            border-radius: 0px 0px 0px 0px;
            -webkit-box-shadow: 0px 16px 29px -17px rgba(33, 20, 4, 1);
            -moz-box-shadow: 0px 16px 29px -17px rgba(33, 20, 4, 1);
            box-shadow: 0px 16px 29px -17px rgba(33, 20, 4, 1);
            border: none;
            margin: auto;
            z-index: 1000;
        }

        .boxElement {
            border-radius: 0px 0px 0px 0px;
            /*-webkit-box-shadow: 3px 0px 23px -5px rgba(33, 20, 4, 1);*/
            /*-moz-box-shadow: 3px 0px 23px -5px rgba(33, 20, 4, 1);*/
            box-shadow: -5px 0 5px -5px #333, 5px 0 5px -5px #333;
        }

        #mapSearch {
            border: 0;
        }

        #container {
            position: fixed;
            top: 0px;
        }

        .leaflet-top {
            /*To prevent cutting off the top element by header bar in dashboard*/
            top: 50px;
        }

        .leaflet-right {
            /* to prevent showing layers controller over objectInfor side pane */
            z-index: 0;
        }

        .leaflet-popup-content {
            width: 200px;
            margin: 6px;
        }

        #objectInfoCloseButton:hover {
            cursor: pointer;
            color: firebrick;
        }

        .sectionJointStyle {
            stroke-dasharray: 3, 20;
        }

    </style>

    <script>
        //TODO: move this scripts to separate file like dispatcher.js in assets file
        var currentDispatchOrderRefId;
        function dispatchCab(){
            if(!currentDispatchOrderRefId){
                $.UIkit.notify({
                    message: '<span style="color: dodgerblue">Please select an order first!</span><br>',
                    status: 'danger',
                    timeout: 3000,
                    pos: 'top-center'
                });
                return false;
            }
            $.post('dispatcher/dispatchVehicle', {refId: currentDispatchOrderRefId}, function (response) {
                $.UIkit.notify({
                    message: '<span style="color: dodgerblue">' + response.status + '</span><br>' + response.message,
                    status: (response.status == 'success' ? 'success' : 'danger'),
                    timeout: 3000,
                    pos: 'top-center'
                });
            });
            currentDispatchOrderRefId = null;
//            location.reload(true);
        }
    </script>
</head>

<body style="margin: 0;padding: 0;">

<div id="container">
    <!-- Sidebar -->
    <div id="map"></div>
</div>

<nav class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><img style="max-width:50px; margin-top: -7px;"
                                              src="<?= base_url() ?>assets/img/hao-logo-small.png"/></a>

        <!-- TODO: for reference, remove if not use
        <div class="navbar-icon-container">
            <a href="#left_side_pannel" data-uk-offcanvas class="navbar-icon pull-right visible-xs"
                    ><i class="fa fa-bars fa-lg" style="color: #FF9900"></i></a>
            <a href="#" class="navbar-icon pull-right visible-xs"
               onclick="$('.navbar-collapse').collapse('toggle');return false;"><i class="fa fa-search fa-lg"
                                                                                   style="color: #FF9900"></i></a>
        </div>
        -->
    </div>
    <div class="navbar-collapse collapse">
        <!-- TODO: for reference, remove if not use
        <ul class="nav navbar-nav">
            <li class="hidden-xs"><a href="#left_side_pannel" data-uk-offcanvas>
                <i class="fa fa-list" style="color: #FF9900"></i></a></li>
        </ul>
        -->
        <ul class="nav navbar-nav">

            <li>
                <form action="#" style="margin: 0px;padding-right: 5px;">
                    <button class="btn btn-sm btn-success navbar-btn">Calling No.</button>
                </form>
            </li>
            <li>
                <form action="#" style="margin: 0px;padding-right: 5px;">
                    <button class="btn btn-sm btn-success navbar-btn">Cab</button>
                </form>
            </li>
            <li>
                <form action="#" style="margin: 0px;padding-right: 5px;">
                    <button class="btn btn-sm btn-success navbar-btn">Cab Location</button>
                </form>
            </li>
            <li>
                <form action="#" style="margin: 0px;padding-right: 5px;">
                    <button class="btn btn-sm btn-success navbar-btn">Advance Booking</button>
                </form>
            </li>
            <li>
                <form action="#" style="margin: 0px;padding-right: 5px;">
                    <button class="btn btn-sm btn-success navbar-btn">Standing orders</button>
                </form>
            </li>
            <li>
                <form action="#" style="margin: 0px;padding-right: 5px;">
                    <button class="btn btn-sm btn-success navbar-btn">Dispatch History</button>
                </form>
            </li>
            <li>
                <form action="#" style="margin: 0px;padding-right: 5px;">
                    <button class="btn btn-sm btn-success navbar-btn">Search cab</button>
                </form>
            </li>
            <li>
                <form action="#" style="margin: 0px;padding-right: 5px;">
                    <button class="btn btn-sm btn-success navbar-btn">Cab lock</button>
                </form>
            </li>

            <li>
                <form action="#" style="margin: 0px;padding-right: 5px;">
                    <button class="btn btn-sm btn-success navbar-btn">Payment</button>
                </form>
            </li>
            <li>
                <form action="#" style="margin: 0px;padding-right: 5px;">
                    <button class="btn btn-sm btn-success navbar-btn">Cab Attendance</button>
                </form>
            </li>
            <li class="dropdown">
                <form action="#" style="margin: 0px;padding-right: 5px;" class="dropdown-toggle" data-toggle="dropdown">
                    <a class="btn btn-sm btn btn-warning navbar-btn">Reports</a>
                </form>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Calling sheet</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Income
                            <report></report>
                        </a></li>
                </ul>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                        style="color: #f9fdff;cursor: pointer;">Dispatcher </span><i
                        class="fa fa-angle-double-down fa-lg"></i></a>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="#" data-toggle="collapse" data-target=".navbar-collapse.in"
                           onclick="$('#aboutModal').modal('show'); return false;">About</a>
                    </li>
                    <li><a href="#">Doc</a></li>
                    <li class="divider"></li>
                    <li><a href="controllers/logout.jag">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>


<div id="objectInfo" style="background: darkgray;display: none;border-radius: 13px;height: 94%;padding: 0"
     class="col-md-2 pull-right">
    <div class="panel-heading text-center">
        <h4> Spatial Object ID: <span id="objectInfoId" class="text-info"></span>
            <i id="objectInfoCloseButton" class="fa fa-times pull-right"
               onclick="$('#objectInfo').animate({width: ['toggle','swing']},200);toggled = false;spatialObject = currentSpatialObjects[selectedSpatialObject];spatialObject.removePath();spatialObject.marker.closePopup();selectedSpatialObject = null;">
            </i>
        </h4>
    </div>
    <div class="panel panel-default" style="max-height: 47%;overflow: auto;box-shadow: 0 0 8px 0 #635749">
        <div class="panel-heading text-center"><h4>Speed variation</h4>
        </div>
        <div class="panel-body">
            <!-- TODO:  setting `margin-left` to increase the area of the chart is a bad hack there should be a better way to do this check :P -->
            <div style="margin: 0;border: none;margin-left: -25px" id="chart_div"></div>
        </div>
    </div>

    <div class="panel panel-default" style="max-height: 47%;overflow: auto;box-shadow: 0px 0px 8px 0px #635749">
        <div class="panel-heading text-center">
            <div class="panel-title"><h4>Alerts</h4></div>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div id="showAlertsArea" class="list-group" style="margin-top: 15px">

            </div>

        </div>
    </div>
    <!--/panel-->
</div>

<div id="left_side_pannel" class="uk-offcanvas" style="z-index: -1;">
    <div class="uk-offcanvas-bar" style="box-shadow: 3px 14px 13px -2px #211404;">
        <ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav>
            <li class="uk-parent" style="box-shadow: 0 2px 12px 1px #2D1600;min-height: 50px;line-height: 25px;">
                <a href="#" style="min-height: 50px;">
                    Hao city cabs Dashboard
                </a>
                <ul class="uk-nav-sub">
                    <li style="color: #969490">
                        Hao city cabs
                    </li>

                </ul>
            </li>
            <li class="uk-nav-header">Alerts</li>
            <li class="uk-parent">
                <a href="#"><i class="fa fa-pencil-square-o"></i> Set alerts</a>
                <ul class="uk-nav-sub">
                    <!-- Set speed limit -->
                    <li>
                        <a style="margin-left: 20%;" data-toggle="modal" href="controllers/modals/speed_alert.jag"
                           data-target="#commonModal"><i
                                class="fa fa-tachometer"></i> Speed alert</a>
                    </li>
                    <li><a style="margin-left: 20%;" data-toggle="modal" href="controllers/modals/proximity_alert.jag"
                           data-target="#commonModal"><i class="fa fa-link"></i> Proximity alert</a></li>
                    <li><a style="margin-left: 20%;color: grey;cursor: not-allowed;"><i class="fa fa-chain-broken"></i>
                            Stationary alert</a></li>
                </ul>
            </li>


            <!-- Set Geo-fence -->
            <li class="uk-parent">
                <a href="#"><i class="fa fa-filter"></i> Geo-fencing</a>
                <ul class="uk-nav-sub">
                    <li><a style="margin-left: 20%;" data-toggle="modal" href="controllers/modals/within_alert.jag"
                           data-target="#commonModal"><i class="fa fa-square-o"></i> Within</a></li>
                    <li><a style="margin-left: 20%;color: grey;cursor: not-allowed;"><i
                                class="fa fa-external-link-square"></i> Approaching</a></li>
                    <li><a style="margin-left: 20%;color: grey;cursor: not-allowed;"><i class="fa fa-minus"></i>
                            Cross</a></li>
                </ul>
            </li>

            <!-- Settings section -->
            <li class="uk-nav-header">Settings</li>
            <!-- Add new tile server url -->
            <li>
                <a data-toggle="modal" data-target="#addTileServer"><i class="fa fa-plus"></i> Add tile server</a>
            </li>
            <!-- Add new WMS server url -->
            <li>
                <a data-toggle="modal" data-target="#addWmsUrl"><i class="fa fa-globe"></i> Add WMS end point</a>
            </li>

            <!-- Place holders need to remove or replace-->
            <li class="uk-nav-header">
                System Administrtion
            </li>

            <!-- TODO: <for reference> remove if not use -->
            <!--<li class="uk-parent">-->
            <!--<a href="site/logs"><i class="fa fa-bar-chart-o"></i> View System Status</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href=""><i class="fa fa-users"></i> Manage Users</a>-->
            <!--</li>-->
        </ul>

    </div>
</div>


<div id="leftSidePane">
    <div class="panel panel-info boxElement" style="position: relative;width: 40%;margin-bottom: 0px
">
        <div class="panel-heading">
            <h3 class="panel-title">Search</h3>
        </div>
        <div class="panel-body">
            <form id="locationSearch" class="navbar-form" role="search"
                  onsubmit="return false;">
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-btn"><button class="btn btn-default" type="button">Search by
                                Location
                            </button></span>
                        <input autofocus="true" id="locationSearchbox" type="text"
                               placeholder="Search For location"
                               class="form-control typeahead">
                        <span id="searchicon" class="fa fa-search form-control-feedback"></span>
                    </div>
                </div>
                <input style="visibility: hidden; position: fixed;" type="submit"/>
            </form>

            <form id="mapSearch" class="navbar-form" role="search"
                  onsubmit="focusOnSpatialObject($(this).find('#searchbox').val());return false;">
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-btn"><button class="btn btn-default" type="button">Search by CabId
                            </button></span><input autofocus="true" id="searchbox"
                                                   type="text"
                                                   placeholder="Search for cab"
                                                   class="form-control typeahead">
                        <span id="searchicon" class="fa fa-search form-control-feedback"></span>
                    </div>
                </div>
                <input style="visibility: hidden; position: fixed;" type="submit"/>
            </form>
        </div>
    </div>

    <div style="position: relative;width: 40%;max-height: 90%;" id="newOrdersPane">
        <?= $new_orders_pane ?>
    </div>

</div>


<div id="loading">
    <div class="loading-indicator">
        <div class="progress progress-striped active">
            <div class="progress-bar progress-bar-info" style="width: 100%"></div>
        </div>
    </div>
</div>

<!-- Modals in use -->
<div class="modal" id="aboutModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Welcome to the BootLeaf template!</h4>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="aboutTabs">
                    <li class="active"><a href="#about" data-toggle="tab"><i class="fa fa-question-circle"></i>&nbsp;About
                            the project</a></li>
                    <li><a href="#contact" data-toggle="tab"><i class="fa fa-envelope"></i>&nbsp;Contact us</a></li>
                    <li><a href="#disclaimer" data-toggle="tab"><i class="fa fa-exclamation-circle"></i>&nbsp;Disclaimer</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-globe"></i>&nbsp;Metadata
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#boroughs-tab" data-toggle="tab">Boroughs</a></li>
                            <li><a href="#subway-lines-tab" data-toggle="tab">Subway Lines</a></li>
                            <li><a href="#theaters-tab" data-toggle="tab">Theaters</a></li>
                            <li><a href="#museums-tab" data-toggle="tab">Museums</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="tab-content" id="aboutTabsContent" style="padding-top: 10px;">
                    <div class="tab-pane fade active in" id="about">
                        <p>A simple, responsive template for building web mapping applications with <a
                                href="http://getbootstrap.com/">Bootstrap 3</a>, <a href="http://leafletjs.com/"
                                                                                    target="_blank">Leaflet</a>, and <a
                                href="http://twitter.github.io/typeahead.js/" target="_blank">typeahead.js</a>. Open
                            source, MIT licensed, and available on <a href="https://github.com/bmcbride/bootleaf"
                                                                      target="_blank">GitHub</a>.</p>

                        <div class="panel panel-primary">
                            <div class="panel-heading">Features</div>
                            <ul class="list-group">
                                <li class="list-group-item">Fullscreen mobile-friendly map template with responsive
                                    navbar and modal placeholders
                                </li>
                                <li class="list-group-item">jQuery loading of external GeoJSON files</li>
                                <li class="list-group-item">Logical multiple layer marker clustering via the <a
                                        href="https://github.com/Leaflet/Leaflet.markercluster" target="_blank">leaflet
                                        marker cluster plugin</a></li>
                                <li class="list-group-item">Elegant client-side multi-layer feature search with
                                    autocomplete using <a href="http://twitter.github.io/typeahead.js/" target="_blank">typeahead.js</a>
                                </li>
                                <li class="list-group-item">Responsive sidebar feature list with sorting and filtering
                                    via <a href="http://listjs.com/" target="_blank">list.js</a></li>
                                <li class="list-group-item">Marker icons included in grouped layer control via the <a
                                        href="https://github.com/ismyrnow/Leaflet.groupedlayercontrol" target="_blank">grouped
                                        layer control plugin</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="disclaimer" class="tab-pane fade text-danger">
                        <p>The data provided on this site is for informational and planning purposes only.</p>

                        <p>Absolutely no accuracy or completeness guarantee is implied or intended. All information on
                            this map is subject to such variations and corrections as might result from a complete title
                            search and/or accurate field survey.</p>
                    </div>
                    <div class="tab-pane fade" id="contact">
                        <form id="contact-form">
                            <div class="well well-sm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="first-name">First Name:</label>
                                            <input type="text" class="form-control" id="first-name">
                                        </div>
                                        <div class="form-group">
                                            <label for="last-email">Last Name:</label>
                                            <input type="text" class="form-control" id="last-email">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="text" class="form-control" id="email">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="message">Message:</label>
                                        <textarea class="form-control" rows="8" id="message"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <p>
                                            <button type="submit" class="btn btn-primary pull-right"
                                                    data-dismiss="modal">Submit
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="boroughs-tab">
                        <p>Borough data courtesy of <a
                                href="http://www.nyc.gov/html/dcp/html/bytes/meta_dis_nyboroughwi.shtml"
                                target="_blank">New York City Department of City Planning</a></p>
                    </div>
                    <div class="tab-pane fade" id="subway-lines-tab">
                        <p><a href="http://spatialityblog.com/2010/07/08/mta-gis-data-update/#datalinks"
                              target="_blank">MTA Subway data</a> courtesy of the <a
                                href="http://www.urbanresearch.org/about/cur-components/cuny-mapping-service"
                                target="_blank">CUNY Mapping Service at the Center for Urban Research</a></p>
                    </div>
                    <div class="tab-pane fade" id="theaters-tab">
                        <p>Theater data courtesy of <a
                                href="https://data.cityofnewyork.us/Recreation/Theaters/kdu2-865w" target="_blank">NYC
                                Department of Information & Telecommunications (DoITT)</a></p>
                    </div>
                    <div class="tab-pane fade" id="museums-tab">
                        <p>Museum data courtesy of <a
                                href="https://data.cityofnewyork.us/Recreation/Museums-and-Galleries/sat5-adpb"
                                target="_blank">NYC Department of Information & Telecommunications (DoITT)</a></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal" id="attributionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    Hao City Cabs System
                </h4>
            </div>
            <div class="modal-body">
                <div id="attribution"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Add tile server input modal -->
<div class="modal" id="addTileServer" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"
                 style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
                    Add tiler server URL <sup id="aboutTileUrl" style="cursor: pointer;" data-toggle="tooltip"
                                              title="What is a tile URL?"><i class="fa fa-question" style="color: #39F;"
                                                                             data-toggle="collapse"
                                                                             data-target="#collapseOne"></i></sup>
                </h4>
            </div>
            <div class="modal-body">
                <div id="urlInput">
                    <div style="height: 0px;" id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p>A string of the following form:</p>
                            <pre><code class="javascript"><span class="string">'http://{s}.somedomain.com/blabla/{z}/{x}/{y}.png'</span></code></pre>
                            <p><code class="javascript">{s}</code> means one of the available subdomains (used
                                sequentially to help with browser parallel requests per domain limitation; subdomain
                                values are specified in options; <code class="javascript">a</code>, <code
                                    class="javascript">b</code> or <code class="javascript">c</code> by default, can
                                be omitted), <code class="javascript">{z}</code> — zoom level, <code class="javascript">{x}</code>
                                and <code class="javascript">{y}</code> — tile coordinates.</p>

                            <p>You can use custom keys in the template, which will be <a
                                    href="#util-template">evaluated</a> from TileLayer options, like this:</p>
                            <pre><code class="javascript">L.tileLayer(<span class="string">'http://{s}.somedomain.com/{foo}/{z}/{x}/{y}.png'</span>,
                                    {foo: <span class="string">'bar'</span>});</code></pre>

                        </div>
                    </div>
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"><i class="fa fa-italic"></i></span>
                        <input autofocus="enable" id="tileName" type="text" class="form-control"
                               placeholder="Tile URL name">
                    </div>
                    <br>

                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                        <input id="tileUrl" class="form-control" type="text"
                               placeholder="http://{s}.somedomain.com/blabla/{z}/{x}/{y}.png">
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="button" onclick="addTileUrl()"><i class="fa fa-plus"></i>
                            </button>
                        </span>
                    </div>

                    <!-- TODO: If need show a preview of the map befor add it to backend -->
                    <!--<h3>  TODO: ask subdomains if any, and maxZoom + Attributions </h3>-->

                    <br/>

                    <div class="panel panel-default" style="width: 80%;">
                        <div>
                            <h4 class="panel-title" style="font-size: 12px;line-height: 1.5;">
                                <button style="text-align: left;" class="btn btn-default btn-xs btn-block collapsed"
                                        onclick="$('.fa-chevron-right').toggleClass('fa-rotate-90')"
                                        data-toggle="collapse" data-parent="#accordion" href="#tileUrlOptions">
                                    <i class="fa fa-chevron-right"></i> Options
                                </button>
                            </h4>
                        </div>
                        <div style="height: 0px;" id="tileUrlOptions" class="panel-collapse collapse">
                            <div class="panel-body">

                                <div class="input-group input-group-sm col-sm-9">
                                    <small class="text-primary">
                                        <label class="col-sm-2 control-label" for="sub_domains">Sub-domains</label>
                                    </small>
                                    <input id="sub_domains" type="text" class="form-control"
                                           placeholder="Enter sub-domains in CSV format">
                                </div>

                                <br/>

                                <div class="input-group input-group-sm col-sm-9">
                                    <small class="text-primary">
                                        <label class="col-sm-9 control-label" for="maxzoom">Max zoom level</label>
                                    </small>
                                    <input id="maxzoom" type="text" class="form-control"
                                           placeholder="Number between(around) 1~19">
                                </div>
                                <br/>

                                <div class="input-group input-group-sm col-sm-9">
                                    <small class="text-primary">
                                        <label class="col-sm-2 control-label" for="data_attribution">Attribution</label>
                                    </small>
                                    <input id="data_attribution" type="text" class="form-control"
                                           placeholder="Enter attribution">
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /Modals in use -->

<!-- Add WMS URL modal -->
<div class="modal" id="addWmsUrl" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"
                 style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
                    Add WMS service end-point<sup id="aboutWms" style="cursor: pointer;" data-toggle="tooltip"
                                                  title="What WMS end-point"><i class="fa fa-question"
                                                                                style="color: #39F;"
                                                                                data-toggle="collapse"
                                                                                data-target="#wmsOverview"></i></sup>
                </h4>
            </div>
            <div class="modal-body">
                <div>
                    <div style="height: 0px;" id="wmsOverview" class="panel-collapse collapse">
                        <div class="panel-body">
                            The OpenGIS® Web Map Service Interface Standard (WMS) provides a simple HTTP interface for
                            requesting geo-registered map images from one or more distributed geospatial databases.
                            A WMS request defines the geographic layer(s) and area of interest to be processed.
                            The response to the request is one or more geo-registered map images (returned as JPEG, PNG,
                            etc) that can be displayed in a browser application.
                            The interface also supports the ability to specify whether the returned images should be
                            transparent so that layers from multiple servers can be combined or not.
                        </div>
                    </div>
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"><i class="fa fa-italic"></i></span>
                        <input autofocus="enable" id="serviceName" type="text" class="form-control"
                               placeholder="Service provider name">
                    </div>

                    <br>

                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"><i class="fa fa-align-justify"></i></span>
                        <input autofocus="enable" id="layers" type="text" class="form-control"
                               placeholder="Service layers as comma seperated values">
                    </div>
                    <br>

                    <div class="input-group input-group-sm">
                        <span class="input-group-addon">V.</span>
                        <input autofocus="enable" id="wmsVersion" type="text" class="form-control"
                               placeholder="WMS version (i.e: 1.1.1 or 1.3.0)">
                    </div>
                    <br>

                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                        <input id="serviceEndPoint" class="form-control" type="text"
                               placeholder="http(s)://sedac.ciesin.columbia.edu/geoserver/wms">
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="button" onclick="addWmsEndPoint()"><i
                                    class="fa fa-plus"></i>
                            </button>
                        </span>
                    </div>

                    <br/>

                    <div class="panel panel-default" style="width: 80%;">
                        <div>
                            <h4 class="panel-title" style="font-size: 12px;line-height: 1.5;">
                                <button style="text-align: left;" class="btn btn-default btn-xs btn-block collapsed"
                                        onclick="$('.fa-chevron-right').toggleClass('fa-rotate-90')"
                                        data-toggle="collapse" data-parent="#accordion" href="#wmsOptions">
                                    <i class="fa fa-chevron-right"></i> Options
                                </button>
                            </h4>
                        </div>
                        <div style="height: 0px;" id="wmsOptions" class="panel-collapse collapse">
                            <div class="panel-body">

                                <div class="input-group input-group-sm col-sm-11">
                                    <small class="text-primary">
                                        <label class="col-sm-6 control-label" for="outputFormat">Output format</label>
                                    </small>
                                    <input id="outputFormat" type="text" class="form-control"
                                           placeholder="Output format (i.e: image/png, image/jpeg, image/svg)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /Modals in use -->

<!-- General modal placeholder , TODO: open all the modal through this wrapper via remote AJAX calls -->
<div class="modal" id="commonModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- This content is load by $.ajax call , pages are located at '/controllers/modals/' -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /Modals in use -->


<!-- Import within-GeoJson modal -->
<div class="modal" id="editWithinGeoJSON" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"
                 style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
                    Edit GeoJson object of the selected area
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-group">
                        <label class="text-primary" for="importGeoJsonFile">Import GeoJson</label>
                        <input id="importGeoJsonFile" type="file">
                        <hr/>

                        <label class="text-primary" for="enterGeoJson">Enter GeoJson</label>
                        <textarea id="enterGeoJson" class="form-control" rows="10"></textarea>
                    </div>
                </div>
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <button id="updateGeoJson" class="btn btn-primary" onclick="importGeoJson()">Import</button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn  btn-default" onclick="closeAll()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /Modals in use -->


<!-- ** comment out below library if using minimized wso2_geo_app.min library **  -->
<script src="<?= base_url() ?>assets/js/app.js"></script>

<!-- Combined and compiled JS with google closure compile-->
<!--<script src="<?= base_url() ?>assets/js/wso2_geo/wso2_geo_app.min.js"></script>-->

<!-- Template HTML components used by JS to inject contents-->
<div style="display: none">
    <div id="markerPopup" class="popover top">
        <div class="arrow"></div>
        <h3 class="popover-title">ID <span id="objectId"></span></h3>

        <div class="popover-content">
            <h6>Information</h6>

            <p id="information" class="bg-primary" style="margin: 0px;padding: 0px;"></p>
            <h6>Speed<span class="label label-primary pull-right"><span id="speed"></span> km/h</span></h6>
            <h6>Heading<span id="heading" class="label label-primary pull-right"></span></h6>
            <button type="button" onclick="dispatchCab()" class="btn btn-info btn-xs">Dispatch</button>
        </div>
    </div>

    <div id="setWithinAlert">
        <form role="form" style="width: auto;">
            <div class="form-group">
                <label class="text-primary" for="queryName">Query name</label>
                <input class="form-control" id="queryName" placeholder="Query name" type="text">
                <span class="help-block">Can use this name to locate the execution plan</span>

                <label class="text-primary" for="areaName">Fence name</label>
                <input class="form-control" id="areaName" placeholder="Fence name" type="text">
                <span class="help-block">Name of the selected area(i.e colombo)</span>
            </div>
            <div>
                <div class="btn-group btn-group-sm btn-group-justified">
                    <div class="btn-group">
                        <button id="addWithinAlert" onclick="setWithinAlert($(this).attr('leaflet_id'))" type="button"
                                class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="left"
                                title="Save selected area for alerts">Save
                        </button>
                    </div>
                    <div class="btn-group">
                        <button id="editGeoJson"
                                onclick="$('#editWithinGeoJSON #updateGeoJson').attr('leaflet_id',$(this).attr('leaflet_id'));$('#editWithinGeoJSON textarea').text(JSON.stringify(map._layers[$(this).attr('leaflet_id')].toGeoJSON(),null, '\t'));$('#editWithinGeoJSON').modal('toggle')"
                                type="button" class="btn btn-default btn-xs">Edit
                        </button>
                    </div>
                    <div class="btn-group">
                        <a id="exportGeoJson" download="geoJson.json" href="#"
                           onclick="exportToGeoJSON(this,JSON.stringify(map._layers[$(this).attr('leaflet_id')].toGeoJSON(),null, '\t'))"
                           class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="left"
                           title="Export selected area as a geoJson file">Export</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="templateLoader"></div>
</div>
</body>
</html>