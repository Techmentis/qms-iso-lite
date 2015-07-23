
<div class="row panel panel-default">
    <div class="col-md-12">
        <?php
		 if ($rediness <= 30) { ?>
            <h2 class="text-danger">You have only <?php echo $rediness ?>%  readiness. You need to upload your formats.</h2>
        <?php } elseif ($rediness > 30 && $rediness <= 90) { ?>
            <h2 class="text-danger">You have only <?php echo $rediness ?>%  readiness. You need to upload your formats.</h2>
        <?php } elseif ($rediness > 90) { ?>
            <h2 class="text-success">Congrats ! most of your formats are up to date. You have <?php echo $rediness ?>%  readiness</h2>
        <?php } ?>

        <?php foreach ($results as $key => $val): ?>
            <table class="table table-responsive">
                <tr><td colspan="2"><h3><?php echo $key ?></h3></td></tr>
                <?php foreach ($val as $result): ?>
                <tr>
                    <td class="col-md-11">
                        <?php
                        if ($result['file'] == 0)
                            echo "<span class='text-danger'>You have not uploaded related files for <strong>" . $result['title'] . "</strong></span>";
                        else
                            echo "<span class='text-success'>Files for <strong>" . $result['title'] . "</strong> are found </span>";
                        ?>
                    </td>
                    <td class="col-md-1">
                        <?php echo $this->Html->link('Add Files', array('controller' => 'master_list_of_formats', 'action' => 'view', $result['id'],1), array('class' => 'btn btn-sm btn-info')) ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </table>
        <?php endforeach ?>
    </div>
</div>