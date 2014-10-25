<div class="col-lg-10">

    <h4>cab ID : <?= $cabId;?></h4></br>
    <h4>Plate Number : <?= $plateNo;?></h4></br>
    <h4>Vehicle Type : <?= $vType;?></h4></br>
    <h4>Model : <?= $model;?></h4></br>
    <h4>Info : <?= $info;?></h4></br>

    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <button type="button" class="btn btn-success" onclick="makeCabFormEditable(<?php echo $cabId;?>,url)">Edit</button>
        </div>
    </div>

</div>