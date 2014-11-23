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
                        <th>Jobs</th>
                        <th>Cancel[T]</th>
                        <th>Cancel[D]</th>
                    </tr>

                    <tr>
                        <td><?= $title?></td>
                        <td><?= $position?></td>
                        <td><?= $name?></td>
                        <td><?= $pRemark?></td>
                        <td><?= $org?></td>
                        <td><?= $profileType?></td>
                        <td><?= $tot_job?></td>
                        <td><?= $tot_cancel?></td>
                        <td><?= $dis_cancel?></td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-12" >
                <div class="col-lg-offset-7 col-lg-3">
                    <?php if($profileType == 'Cooperate'):?>
                    <div class="input-group">
                        <input type="text" class="form-control" id="cooperateUserTp" placeholder="Land / Mobile">
                              <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="operations('addUser');return false;" onsubmit="operations('addUser');return false;">Add User</button>
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

            <?php if(isset($userInfo)):?>
            <div class="col-lg-12" >
                <h4>Personal Profiles</h4>
                    <div class="col-lg-12" style="max-height: 200px ; overflow: auto">
                        <table class="table table-striped" >
                            <tr>
                                <th>Title</th>
                                <th>Position</th>
                                <th>Name</th>
                                <th>tp1</th>
                                <th>tp2</th>
                                <th>Permanent Remarks</th>
                                <th>Organization</th>
                            </tr>

                            <?php foreach($userInfo as $item):?>
                            <tr>
                                <td><?= $item['title'];?></td>
                                <td><?= $item['position'];?></td>
                                <td><?= $item['name'];?></td>
                                <td><?= $item['tp'];?></td>
                                <td><?= $item['tp2'];?></td>
                                <td><?= $item['pRemark'];?></td>
                                <td><?= $item['org'];?></td>
                            </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                <?php endif;?>
            </div>
        </div>
</div>

