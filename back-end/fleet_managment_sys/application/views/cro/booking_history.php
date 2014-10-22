<div class="col-lg-12">
    <table class="table table-striped" >
        <tr>
            <th>Ref ID</th>
            <th>Name</th>
            <th>Permanent Remarks</th>
            <th>Organization</th>
            <th>Destination</th>
        </tr>

        <tr>
            <td><?= $title?></td>
            <td><?= $name?></td>
            <td><?= $pRemark?></td>
            <td><?= $org?></td>
            <td><?= $des?></td>
        </tr>
    </table>
</div>
<div class="col-lg-offset-10 col-lg-2" >
    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <button type="button" class="btn btn-success" onclick="operations('editCus', '<?= $tp;?>' )">Edit Information</button>
        </div>
    </div>