<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Call History</h3>
    </div>
    <div class="panel-body" >
        <div class="col-lg-12" style="max-height: 200px ; overflow: auto">
            <?php if(isset($call_history) && sizeof($call_history) != 0):?>
                <table class="table table-striped" ><tr>
                        <th>Call Time</th>
                        <th>CRO</th>
                    </tr>
                    <?php foreach (array_reverse($call_history) as $item):?>
                        <tr>
                            <td><?=  date('H:i:s Y-m-d ', $item['callTime']->sec);?></td>
                            <td><?=  $item['croId'];?></td>

                        </tr>
                    <?php endforeach;?>

                </table>
            <?php endif?>

            <?php if(!isset($call_history)):?>
                <div class="col-lg-offset-5 col-lg-5">
                    <h4>EMPTY</h4>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>

