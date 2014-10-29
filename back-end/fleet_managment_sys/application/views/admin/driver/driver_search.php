<div class="col-lg-10">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Driver Details</h3>
        </div>
        <div class="panel-body" id="singleDriver">
            <div >

                <h4>Driver ID : <?= $driverId;?></h4></br>
                <h4>Name : <?= $name?></h4></br>
                <h4>User Name : <?= $uName;?></h4></br>
                <h4>Pass : <?= $pass;?></h4></br>
                <h4>NIC Number : <?= $nic;?></h4></br>
                <h4>Telephone Number : <?= $tp;?></h4></br>
                <h4>Cab ID : <?php
                    if(!isset($cabId) || trim($cabId)==''){
                        echo "empty";
                    }else{
                       echo $cabId;
                    }
                    ?></h4></br>

                <button type="button" class="btn btn-danger btn-lg" onclick="makeDriverFormEditable(<?php echo $driverId;?>,url)"
                        style="float: right">Edit</button>
            </div>
        </div>

    </div>
</div>