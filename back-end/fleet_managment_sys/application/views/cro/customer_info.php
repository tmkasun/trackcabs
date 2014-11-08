<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Customer Information</h3>
    </div>
        <div class="panel-body" >
            <div class="col-lg-12">
                <table class="table table-striped" >
                    <tr>
                        <th>Title</th>
                        <th>Position</th>
                        <th>Name</th>
                        <th>Permanent Remarks</th>
                        <th>Organization</th>
                        <th>Profile Type</th>
                    </tr>

                    <tr>
                        <td><?= $title?></td>
                        <td><?= $position?></td>
                        <td><?= $name?></td>
                        <td><?= $pRemark?></td>
                        <td><?= $org?></td>
                        <td><?= $profileType?></td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-offset-8 col-lg-4" >
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" onclick="operations('editCus', '<?= $tp;?>' )">Edit Info</button>
                    </div>
                    <?php if($profileType == 'Cooperate'):?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" onclick="operations('addCustomer', '<?= $tp;?>' )">Add User</button>
                        </div>
                    <?php endif;?>
                </div>
            </div>

            <div class="col-lg-12">
                
            </div>
        </div>
</div>

