<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="DataEntry ">
        <h4><?php echo __('Data Entry Report'); ?>
            <span class=""></span>
            <?php
                echo $this->Form->create('Report', array('action' => 'daily_data_entry_export', 'class' => 'no-padding no-margin pull-right'));
                echo $this->Form->hidden('from', array('value' => $this->data['reports']['from']));
                echo $this->Form->hidden('to', array('value' => $this->data['reports']['to']));
                echo $this->Form->submit('Export', array('class' => 'btn btn-info pull-right', 'style' => 'padding-left:20px;padding-right:20px;'));
                echo $this->Form->end();
            ?>
            <span class=""></span>
        </h4>
	<br />
        <?php foreach ($branchDetails as $details): ?>
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading"><div class="panel-title">
                            <h3><?php echo $details['Branch']['Branch']['name'] ?>
                                <span class="pull-right"><?php echo __('Benchmark : ') . $details['Branch']['Benchmark'] . __(' Records Added: ') . $details['Branch']['Data'] ?></span></h3>
                        </div></div>
                    <div class="panel-body">
                        <?php foreach ($details['Branch']['Department'] as $departments): ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <h5><?php echo $departments['Department']['Department']['name'] ?></h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $departments['Data'] * 100 / $details['Branch']['Benchmark'] ?>%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($departments['Benchmark']['Benchmark']['benchmark'] * 100 / $details['Branch']['Benchmark']) ?>%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <span><?php echo __('Benchmark : '); ?><b><?php echo $departments['Benchmark']['Benchmark']['benchmark'] ?></b></span>
                                </div>
                                <div class="col-md-2">
                                    <span><?php echo __('Records Added : '); ?><b><?php echo $departments['Data'] ?></b></span>
                                </div>

                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading"><div class="panel-title">
                        <h3><?php echo __('Userwise'); ?>
                            <span class="pull-right"><?php echo __('Benchmark : ') . $total . __(' Records Added: ') . $recs ?></span></h3>
                    </div></div>
                <div class="panel-body">
                    <?php foreach ($userDetails as $user): ?>
                        <div class="row">
                            <div class="col-md-2">
                                <h5><?php echo $user['User']['User']['name'] ?></h5>
                            </div>
                            <div class="col-md-6">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $user['Data'] * 100 / $user['User']['User']['benchmark'] ?>%">
                                        <span class="sr-only">40% Complete (success)</span>
                                    </div>
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($user['User']['User']['benchmark'] * 100 / $total) ?>%">
                                        <span class="sr-only">40% Complete (success)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <span><?php echo __('Benchmark : '); ?><b><?php echo $user['User']['User']['benchmark'] ?></b></span>
                            </div>
                            <div class="col-md-2">
                                <span><?php echo __('Records Added : '); ?><b><?php echo $user['Data'] ?></b></span>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->element('send_file'); ?>
    <?php echo $this->element('common'); ?>
    <?php echo $this->Js->writeBuffer(); ?>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>