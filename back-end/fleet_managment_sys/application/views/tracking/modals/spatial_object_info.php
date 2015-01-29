<script type="text/javascript">
    $(
        function () {
            drawChart();
        }
    );

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Speed', 5]
        ]);

        var options = {
            width: 300, height: 120,
            greenFrom: 10, greenTo: 70,
            yellowFrom: 75, yellowTo: 90,
            redFrom: 90, redTo: 120,
            minorTicks: 10
        };

        var chart = new google.visualization.Gauge(document.getElementById('gchart_div'));

        chart.draw(data, options);

        setInterval(function () {
            data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
            chart.draw(data, options);
        }, 1000);
    }
</script>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <i style="background: darkgrey;color: floralwhite;padding: 10px;border-radius: 50%"
                       class="fa fa-taxi fa-5x"></i>
                </div>
                <div class="col-md-6">
                    <div id="gchart_div"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>Cab ID</td>
                            <td>***</td>
                        </tr>

                        <tr>
                            <td>UserId</td>
                            <td>@twitter</td>
                        </tr>

                        <tr>
                            <td>Plate No</td>
                            <td>TE-STING</td>
                        </tr>
load we
                        <tr>
                            <td>Model</td>
                            <td>TE</td>
                        </tr>

                        <tr>
                            <td>Color</td>
                            <td>Black</td>
                        </tr>

                        <tr>
                            <td>Info</td>
                            <td>@twitter</td>
                        </tr>
                        <!--                        Cab ID	Plate No	Model	Color	UserId	Zone	Info-->
                        </tbody>
                    </table>
                </div>

                <button type="button" class="btn btn-default btn-xs">Travel History</button>
                <button type="button" class="btn btn-default btn-xs">Orders path</button>
            </div>
        </div>
    </div>
</div>
