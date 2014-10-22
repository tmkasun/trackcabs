<div class="col-lg-10">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Cab Details</h3>
        </div>
        <div class="panel-body" id="singleCab">
            <div >

                <h4>Driver ID : <?= $item['driverId'];?></h4></br>
                <h4>Name : <?= $item['name'];?></h4></br>
                <h4>User Name : <?= $item['uName'];?></h4></br>
                <h4>Pass : <?= $item['pass'];?></h4></br>
                <h4>NIC Number : <?= $item['nic'];?></h4></br>
                <h4>Telephone Number : <?= $item['tp'];?></h4></br>
                <h4>Cab ID : <?php
                    if(array_key_exists("cabId", $item)){
                        echo $item['cabId'];
                    }elseif(!array_key_exists("cabId", $item)){
                        echo 'empty';
                    }
                    ?></h4></br>

                <button type="button" class="btn btn-danger btn-lg" onclick="makeCabFormEditable(<?php echo $cabId;?>)"
                        style="float: right">Edit</button>
            </div>
        </div>

    </div>
</div>