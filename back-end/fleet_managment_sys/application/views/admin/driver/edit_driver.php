<form role="form" id="editDrivers">
    <div class="form-group">
        <label for="cabId">Driver ID</label>
        <input type="text" class="form-control" id="userId"  readonly="readonly" value="<?= $userId;?>">
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
        <label for="cabIdAssigned">Can Logout</label>
        <select class="form-control" id="logout" placeholder="Can Logout?" >
            <option <?php if($logout=='true')echo "selected";?> value="true">Yes</option>
            <option <?php if($logout=='false')echo "selected";?> value="false">No</option>
        </select>
    </div>
    <div class="form-group">
        <label for="cabIdAssigned">Cab ID</label>
<!--        <input type="text" class="form-control" id="cabId" placeholder="Enter Cab ID" value="<? //$cabId;?>">-->
        <select class="form-control" id="cabId" >
            <option value="-1" selected=""><?php if($cabId == -1){echo "Assign Later";}else{echo "Remove Cab";}?></option>            
            <?php
            if($cabId != -1){echo '<option value="'.$cabId.'" selected>'.$cabId.'</option>';}
            $i = 0;            
            foreach($cab_ids as $cabId_uu){echo '<option value="'.$cabId_uu['cabId'].'">'.$cabId_uu['cabId'].'</option>';$i++;}
            ?>
        </select>    
    </div>
    <div class="form-group">
        <label for="blocked">Blocked</label>
        <select class="form-control" id="blocked" placeholder="Blocked ?" >
            <option <?php if($blocked=='true')echo "selected";?> value="true">Yes</option>
            <option <?php if($blocked=='false')echo "selected";?> value="false">No</option>
        </select>
    </div>
    <button type="submit" class="btn btn-default" onclick="updateCRO('<?php echo $user_type?>')">Save</button>
</form>