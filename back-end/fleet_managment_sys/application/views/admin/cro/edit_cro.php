<form role="form" id="editCROs">
    <div class="form-group">
        <label for="croId">CRO ID</label>
        <input type="text" class="form-control" id="croId"  readonly="readonly" value="<?= $croId;?>">
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

    <button type="submit" class="btn btn-default" onclick="updateCRO(url, docs_per_page , page );">Save</button>
</form>