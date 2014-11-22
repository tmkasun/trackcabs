<table class="table table-striped" >
    <tr>
        <th>Package Id</th>
        <th>Package Name</th>
        <th>Price</th>
        <th>Info</th>
        <th>Action</th>


    </tr>


    <?php foreach ($data as $item):?>

        <tr>
            <td><p id="<?= $item['packageId'];?>"><?= $item['packageId'];?></p></td>
            <td><p id="<?= $item['packageName'];?>"><?= $item['packageName'];?></p></td>
            <td><?= $item['fee'];?></td>
            <td><?= $item['info'];?></td>
            <td><button type="submit" class="btn btn-default" onclick="makePackagesFormEditable('<?= $item['packageId'];?>')">Edit</button></td>
        </tr>

    <?php endforeach;?>
</table>