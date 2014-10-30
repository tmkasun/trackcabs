
<form  class="form-inline" role="form" >
    <select class="form-control" id="title">Select a Title
        <option selected value="-">Title</option>
        <option value="Ms">Ms</option>
        <option value="Miss">Miss</option>
        <option value="Mrs">Mrs</option>
        <option value="Mr">Mr</option>
        <option value="Rev">Rev</option>
        <option value="Doc">Doc</option>
    </select>

    <select id="position" class="form-control">
        <option selected value="-">Position</option>
        <option value="Dig">Dig</option>
        <option value="Mag">Mag</option>
        <option value="Col">Col</option>
    </select>
</form>

<form role="form" id="editCustomer" class="customerForm">
    <div class="form-group">
        <label for="tp">Telephone Number</label>
        <input type="text" class="form-control" id="tp" placeholder="Telephone Number" value="<?= $tp?>">
        <div class="checkbox">
            <label>
                <input type="checkbox" id="type1" <?php if($type1 == 'land')echo 'checked';?>> Land
            </label>
        </div>
    </div>
    <div class="form-group">
        <label for="tp2">Telephone Number 2</label>
        <input type="text" class="form-control" id="tp2" placeholder="Telephone Number" value="<?= $tp2?>">
        <div class="checkbox">
            <label>
                <input  id="type2" type="checkbox" <?php if($type2 == 'land')echo 'checked';?>> Land
            </label>
        </div>
    </div>
    <div class="form-group">
        <label for="cusName">Customer Name</label>
        <input type="text" class="form-control" id="cusName" placeholder="Customer Name" value="<?= $name?>">
    </div>
    <div class="form-group">
        <label for="pRemark">Permanent Remark</label>
        <input type="text" class="form-control" id="pRemark" placeholder="Permanent Remark" value="<?= $pRemark?>">
    </div>
    <div class="form-group">
        <label for="organization">Organization</label>
        <input type="text" class="form-control" id="organization" placeholder="Organization Name" value="<?= $org?>">
    </div>
    <div class="form-group">
        <label for="destination">Destination</label>
        <input type="text" class="form-control" id="destination" placeholder="Destination" value="<?= $des?>">
    </div>
    <button type="submit" class="btn btn-default" onclick="operations('updateCusInfo')">Save</button>
</form>