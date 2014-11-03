<div class="col-lg-6 ">


    <table class="table table-striped">
        <tr>
            <th>CRO ID</th>
            <th>Name</th>
            <th>User Name</th>
            <th>Pass</th>
            <th>NIC</th>
            <th>tp</th>
            <th>User Type</th>
            <th>Action</th>
        </tr>
        <tr>
            <td><?= $userId; ?></td>
            <td><?= $name ?></td>
            <td><?= $uName; ?></td>
            <td><?= $pass; ?></td>
            <td><?= $nic; ?></td>
            <td><?= $tp; ?></td>
            <td><?= $user_type; ?></td>
            <td><div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success" onclick="makeCROFormEditable(<?= $userId; ?>,url, '<?php echo $user_type; ?>')">Edit</button>
                    </div>
                </div>
            </td>
        </tr>

    </table>

    </br>



</div>