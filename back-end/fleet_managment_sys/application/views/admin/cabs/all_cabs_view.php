<table class="table table-striped" >
    <tr>
        <th>CAB ID</th>
        <th>Plate Number</th>
        <th>Vehicle Type</th>
        <th>Model</th>
        <th>Info</th>
        <th>Colour</th>
    </tr>

    <?php foreach ($data as $item):?>


        <tr>
            <td><?= $item['cabId'];?>
            </td>
            <td><?= $item['plateNo'];?></td>
            <td><?= $item['vType'];?></td>
            <td><?= $item['model'];?></td>
            <td><?php
                if(array_key_exists("info", $item)){
                    echo $item['info'];
                }elseif(!array_key_exists("info", $item)){
                    echo 'empty';
                }
                ?>
            </td>
            <td><?php
                if(array_key_exists("color", $item)){
                    echo $item['color'];
                }elseif(!array_key_exists("color", $item)){
                    echo 'empty';
                }
                ?></td>
        </tr>


    <?php endforeach;?>

    </table>

