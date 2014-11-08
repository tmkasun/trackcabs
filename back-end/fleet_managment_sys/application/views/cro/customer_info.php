<div class="panel panel-default" xmlns="http://www.w3.org/1999/html">
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
            <div class="col-lg-12" >
                <div class="col-lg-offset-7 col-lg-3">
                    <?php if($profileType == 'Cooperate'):?>
                    <div class="input-group">
                        <input type="text" class="form-control">
                              <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Add User</button>
                              </span>
                    </div><!-- /input-group -->
                    <?php endif;?>
                </div>
                <div class="col-lg-2">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" onclick="operations('editCus', '<?= $tp;?>' )">Edit Info</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <?php if(isset($userInfo)):?>

                    <table class="table table-striped" >
                        <tr>
                            <th>Title</th>
                            <th>Position</th>
                            <th>Name</th>
                            <th>Permanent Remarks</th>
                            <th>Organization</th>
                        </tr>

                        <?php foreach($userInfo as $item)?>
                        <tr>
                            <td><?= $item['title'];?></td>
                            <td><?= $item['position'];?></td>
                            <td><?= $item['name'];?></td>
                            <td><?= $item['pRemark'];?></td>
                            <td><?= $item['org'];?></td>
                        </tr>
                    </table>
                <?php endif;?>
            </div>
        </div>
</div>

