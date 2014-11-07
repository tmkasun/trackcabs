<div class="col-lg-12">
    <table class="table table-striped" >
        <tr>
            <th>Title</th>
            <th>Position</th>
            <th>Name</th>
            <th>Permanent Remarks</th>
            <th>Organization</th
        </tr>

        <tr>
            <td><?= $title?></td>
            <td><?= $position?></td>
            <td><?= $name?></td>
            <td><?= $pRemark?></td>
            <td><?= $org?></td>
        </tr>
    </table>
</div>
<div class="col-lg-offset-8 col-lg-4" >
    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <button type="button" class="btn btn-default" onclick="operations('editCus', '<?= $tp;?>' )">Edit Info</button>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default" onclick="operations('editCus', '<?= $tp;?>' )">Add User</button>
        </div>
    </div>
</div>


<div class="col-lg-offset-10 col-lg-2" >
    <div class="btn-group btn-group-justified">

    </div>
</div>