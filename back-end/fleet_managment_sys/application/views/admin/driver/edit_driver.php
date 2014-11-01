<form role="form" id="editDrivers">
    <div class="form-group">
        <label for="cabId">Driver ID</label>
        <input type="text" class="form-control" id="driverId"  readonly="readonly" value="<?= $driverId;?>">
    </div>
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" class="form-control" id="name" placeholder="Enter Full Name" value="<?= $name;?>">
    </div>
    <div class="form-group">
        <label for="uName">User Name</label>
        <input type="text" class="form-control" id="uName" placeholder="Enter User Name" value="<?= $uName;?>">
    </div>
    <div class="form-group">
        <label for="pass">PassWord</label>
        <input type="text" class="form-control" id="pass" placeholder="Enter PassWord" value="<?= $pass;?>">
    </div>
    <div class="form-group">
        <label for="nic">NIC Number</label>
        <input type="text" class="form-control" id="nic" placeholder="Enter NIC Number" value="<?= $nic;?>">
    </div>
    <div class="form-group">
        <label for="tp">Telephone Number</label>
        <input type="text" class="form-control" id="tp" placeholder="Enter Telephone Number" value="<?= $tp;?>">
    </div>
    <div class="form-group">
        <label for="cabIdAssigned">Cab ID</label>
        <input type="text" class="form-control" id="cabIdAssigned" placeholder="Enter Cab ID" value="<?= $cabId;?>">
    </div>
    <button type="submit" class="btn btn-default" onclick="updateDriver(url, docs_per_page , page )">Save</button>
</form>