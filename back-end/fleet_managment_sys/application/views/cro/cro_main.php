<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <style>
        #the-basics .tt-dropdown-menu {
            max-height: 150px;
            overflow-y: auto;
        };

    </style>

    <!-------------------------------- CSS Files------------------------------------>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap-datetimepicker.css">
    <!-------------------------------- JS Files------------------------------------>
    <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/cro_operations.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script src="<?= base_url() ?>assets/js/typeahead.bundle.min.js"><script>


        <script>
        var docs_per_page= 100 ;
        var page = 1 ;
        var obj = null;
        var tp;
        </script>
</head>
<body>
<div id="navBarField">
    <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Hao Cabs</a>
        </div>

        <ul class="nav navbar-nav">
            <li class="active"><a href="#" onclick="getAllCabs()">CRO</a></li>
            <li><a href="#" onclick="getDriversView()">Drivers</a></li>
        </ul>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <form class="navbar-form navbar-left" role="search" id="getCab">
                <div class="form-group">
                    <input class="form-control" placeholder="Customer TP" type="text" id="cusTp">
                </div>
                <button type="submit" class="btn btn-default" onclick="getCustomer()">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</div>

<div class="container-fluid">
    <div class="row" style="background: #d7ddeb">
        <div class="col-lg-12" style="margin-top: 10px">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Job Information</h5>
                </div>
                <div class="panel-body" id="">

                    <div class="col-lg-5" >
                        <div class="col-lg-12" id="mainSearch">
                            <div class="input-group" id="the-basics">

                                    <input type="text" class="form-control  typeahead" placeholder="Mobile / LandLine" id="tpSearch">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" onclick="operations('getCustomer')">
                                                <span class="glyphicon glyphicon-search"></span> Search
                                            </button>
                                        </span>

                            </div>
                            <hr>

                        </div>
                    </div>

                    <div class="col-lg-7" id="jobInfo" style="border-left: 2px solid #a6a6a6" >

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12" style="margin-top: 10px">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Customer Information</h3>
                </div>
                <div class="panel-body" id="customerInformation">



                </div>
            </div>
        </div>


        <div class="col-lg-12" style="margin-top: 10px">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">New Order</h3>
                </div>
                <div class="panel-body" id="newBooking">



                </div>
            </div>
        </div>
</div>

    <script>
        $("#tpSearch").keyup(function(event){
            var url = '<?= site_url(); ?>';
            var tp = $("#tpSearch").val();
            getSimilarTpNumbers(url,tp)
        });
    </script>

    <script>
        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
                var matches, substrRegex;

// an array that will be populated with substring matches
                matches = [];

// regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');

// iterate through the pool of strings and for any string that
// contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, str) {
                    if (substrRegex.test(str)) {
// the typeahead jQuery plugin expects suggestions to a
// JavaScript object, refer to typeahead docs for more info
                        matches.push({ value: str });
                    }
                });

                cb(matches);
            };
        };

        var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
            'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
            'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
            'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
            'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
            'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
            'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
            'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
            'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
        ];

        $('#the-basics .typeahead').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                name: 'states',
                displayKey: 'value',
                source: substringMatcher(states)
            });
    </script>


    <script>
        function operations(request,param1){
            var url = '<?= site_url(); ?>';
            if(request=="editCus"){
                editCustomerInfoEditView( url , param1 );
            }

            if(request == 'updateCusInfo'){
                updateCustomerInfoView( url );
            }
            if(request == 'getCustomer'){
                tp      = document.getElementById("tpSearch").value;
                getCustomerInfoView( url , tp );
            }
            if(request == 'createCusInfo'){
                createCusInfo( url );
            }
            if(request == 'createBooking'){
                alert('create Booking ' + tp);
                createBooking(url , tp)
            }
        }
    </script>

    <script>
        function work(){
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
    </script>



<script>
    $(document).ready(function(){
            //$("#test").hide();

        $("#show").click(function(){
            $("#test").collapse();
        });
    });
</script>


</body>
</html>