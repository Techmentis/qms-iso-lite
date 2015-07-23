<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="trainingNeedIdentifications ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Training Need Identifications', 'modelClass' => 'TrainingNeedIdentification', 'options' => array("sr_no" => "Sr No", "remarks" => "Remarks"), 'pluralVar' => 'trainingNeedIdentifications'))); ?>

        <script type="text/javascript">
            $(document).ready(function() {
                $('table th a, .pag_list li span a').on('click', function() {
                    var url = $(this).attr("href");
                    $('#main').load(url);
                    return false;
                });
            });
        </script>

        <div class="table-responsive">
            <?php echo $this->Form->create(array('class' => 'no-padding no-margin no-background')); ?>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th><?php echo $this->Paginator->sort('employee_id', __('Employee')); ?></th>
                    <th><?php echo $this->Paginator->sort('course_id', __('Course')); ?></th>
                    <th><?php echo $this->Paginator->sort('schedule_id', __('Schedule')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>

                <?php
                    if ($trainingNeedIdentifications) {
                        $x = 0;
                        foreach ($trainingNeedIdentifications as $trainingNeedIdentification):
                ?>
                <tr>

                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $trainingNeedIdentification['TrainingNeedIdentification']['created_by'], 'postVal' => $trainingNeedIdentification['TrainingNeedIdentification']['id'], 'softDelete' => $trainingNeedIdentification['TrainingNeedIdentification']['soft_delete'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($trainingNeedIdentification['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $trainingNeedIdentification['Employee']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($trainingNeedIdentification['Course']['title'], array('controller' => 'courses', 'action' => 'view', $trainingNeedIdentification['Course']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($trainingNeedIdentification['Schedule']['name'], array('controller' => 'schedules', 'action' => 'view', $trainingNeedIdentification['Schedule']['id'])); ?>
                    </td>
                    <td><?php echo h($trainingNeedIdentification['PreparedBy']['name']); ?>&nbsp;</td>
                    <td><?php echo h($trainingNeedIdentification['ApprovedBy']['name']); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($trainingNeedIdentification['TrainingNeedIdentification']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                </tr>
                <?php
                    $x++;
                    endforeach;
                    } else {
                ?>
                <tr><td colspan=16><?php echo __('No results found'); ?></td></tr>
                <?php } ?>
            </table>
            <?php echo $this->Form->end(); ?>
        </div>
        <p>
            <?php
                echo $this->Paginator->options(array(
                    'update' => '#main',
                    'evalScripts' => true,
                    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
                    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
                ));

                echo $this->Paginator->counter(array(
                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                ));
            ?>
        </p>
        <ul class="pagination">
            <?php
                echo "<li class='previous'>" . $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) . "</li>";
                echo "<li>" . $this->Paginator->numbers(array('separator' => '')) . "</li>";
                echo "<li class='next'>" . $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')) . "</li>";
            ?>
        </ul>
    </div>
</div>

<?php echo $this->element('export'); ?>
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "remarks" => "Remarks"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "remarks" => "Remarks"))); ?>
<?php echo $this->element('approvals'); ?>
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