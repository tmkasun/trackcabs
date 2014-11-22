<form role="form" id="editDispatchers">
    <div class="form-group">
        <label for="packageId">Package Id</label>
        <input type="text" class="form-control" id="packageId" readonly value="<?= $packageId;?>">
    </div>
    <div class="form-group">
        <label for="packageName">Package Name</label>
        <input type="text" class="form-control" id="packageName" placeholder="Enter Name"  value="<?= $packageName;?>">
    </div>
    <div class="form-group">
        <label for="fee">Fee</label>
        <input type="text" class="form-control" id="fee" placeholder="Enter Fee" value="<?= $fee;?>">
    </div>
    <div class="form-group">
        <label for="info">Info</label>
        <input type="text" class="form-control" id="info" placeholder="Enter Info" value="<?= $info;?>">
    </div>
    <button type="submit" class="btn btn-default" onclick="updatePackage('<?php echo $packageId;?>')">Save</button>
    <button type="submit" class="btn btn-default" onclick="deletePackage('<?php echo $packageId;?>')">Delete</button>
</form>