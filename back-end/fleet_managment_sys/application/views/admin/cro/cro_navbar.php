<nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <a class="navbar-brand" href="#">Cao Cabs Admin Panel</a>
    </div>

    <ul class="nav navbar-nav">
        <li><a href="#" onclick="getCabsDefaultView(url, docs_per_page , page)">Cabs</a></li>
        <li><a href="#" onclick="getDriversView()">Drivers</a></li>
        <li class="active"><a href="#" onclick="getDispatchersView()">Dispatcher</a></li>
        <li><a href="#" onclick="getCROsView()">CRO</a></li>
    </ul>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <form class="navbar-form navbar-left" role="search" id="getCRO">
            <div class="form-group">
                <input class="form-control" placeholder="CRO ID" type="text" id="croIdSearch">
            </div>
            <button type="submit" class="btn btn-default" onclick="getCROView()">Submit</button>
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