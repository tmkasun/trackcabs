<div class="col-lg-10">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">CRO Details</h3>
        </div>
        <div class="panel-body" id="singleCRO">
            <div >

                <h4>CRO ID : <?= $croId;?></h4></br>
                <h4>Name : <?= $name?></h4></br>
                <h4>User Name : <?= $uName;?></h4></br>
                <h4>Pass : <?= $pass;?></h4></br>
                <h4>NIC Number : <?= $nic;?></h4></br>
                <h4>Telephone Number : <?= $tp;?></h4></br>
                </br>

                <button type="button" class="btn btn-danger btn-lg" onclick="makeCROFormEditable(<?= $croId;?>,url)"
                        style="float: right">Edit</button>
            </div>
        </div>

    </div>
</div>