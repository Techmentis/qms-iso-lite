<h4> <?php echo __('Key Responsibility Areas'); ?> </h4>
<div id ="apparaisal_kra">
<table class="table table-responsive">
    <tr>
        <th><?php echo __('Title'); ?></th>
        <th><?php echo __('Description'); ?></th>
        <th><?php echo __('Target'); ?></th>
        <th><?php echo __('Target Achieved'); ?></th>
    </tr>
    <?php $key=0; foreach ($kras as $kra):?>
        <tr>
            <td>
                <?php echo h($kra['EmployeeKra']['title']); ?>&nbsp;
            </td>
            <td>
                <?php echo h($kra['EmployeeKra']['description']); ?>&nbsp;
            </td>
            <td>
                <?php echo h($kra['EmployeeKra']['target']); ?>&nbsp;
            </td>
            <?php if($kra['EmployeeKra']['target_achieved']>0){ ?>
            <td style="vertical-align: top;width:  30%;">
                <script>
                        $(function() {
                            $("#slider-<?php echo $key; ?>").slider({
                                range: "min",
                                min: 0,
                                max: 100,
                                value: <?php echo $kra['EmployeeKra']['target_achieved']; ?>,
                                slide: function(event, ui) {
                                    $("#vals-<?php echo $key; ?>").html(ui.value + '%');
                                    $("#<?php echo $key; ?>").val(ui.value);

                                },
                                stop: function(event, ui) {
                                    $("#vals-<?php echo $key; ?>").html(ui.value + '%');
                                    $("#EmployeeKra<?php echo $key; ?>TargetAchieved").val(ui.value);



                                }
                            });

                        });
                    </script>

                        <div class=" no-margin col-md-12" id="slider-<?php echo $key; ?>"></div>
                        <div id="vals-<?php echo $key; ?>" class="col-md-2 pull-right" width = "500%"><span><?php echo $kra['EmployeeKra']['target_achieved']; ?>%</span></div>
                    </td>
            <?php } else{ ?>
                    <td style="vertical-align: top;width:  30%;">
                <script>
                        $(function() {
                            $("#slider-<?php echo $key; ?>").slider({
                                range: "min",
                                min: 0,
                                max: 100,
                                value: 0,
                                slide: function(event, ui) {
                                    $("#vals-<?php echo $key; ?>").html(ui.value + '%');
                                    $("#<?php echo $key; ?>").val(ui.value);

                                },
                                stop: function(event, ui) {
                                    $("#vals-<?php echo $key; ?>").html(ui.value + '%');
                                    $("#EmployeeKra<?php echo $key; ?>TargetAchieved").val(ui.value);



                                }
                            });

                        });
                    </script>

                        <div class=" no-margin col-md-12" id="slider-<?php echo $key; ?>"></div>
                        <div id="vals-<?php echo $key; ?>" class="col-md-2 pull-right" width = "500%"><span>%</span></div>
                    </td>
            <?php } ?>
                </tr>
            <?php echo $this->Form->input('EmployeeKra.' . $key . '.id', array('type' => 'hidden', 'value' => $kra['EmployeeKra']['id'])); ?>
            <?php echo $this->Form->input('EmployeeKra.' . $key . '.target_achieved', array('type' => 'hidden', 'value' => $kraList['EmployeeKra']['target_achieved'])); ?>

    <?php  $key++;endforeach; ?>
</table>
</div>