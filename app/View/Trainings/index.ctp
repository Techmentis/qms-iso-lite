<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="trainings ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Trainings', 'modelClass' => 'Training', 'options' => array("sr_no" => "Sr No", "title" => "Title", "description" => "Description", "start_date_time" => "Start Date Time", "end_date_time" => "End Date Time"), 'pluralVar' => 'trainings'))); ?>

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
                    <th><?php echo $this->Paginator->sort('title', __('Title')); ?></th>
                    <th><?php echo $this->Paginator->sort('course_id', __('Course')); ?></th>
                    <th><?php echo $this->Paginator->sort('trainer_id', __('Trainer')); ?></th>
                    <th><?php echo $this->Paginator->sort('trainer_type_id', __('Trainer Type')); ?></th>
                    <th><?php echo $this->Paginator->sort('course_type_id', __('Course Type')); ?></th>
                    <th><?php echo $this->Paginator->sort('atendees', __('Attendees')); ?></th>
                    <th><?php echo $this->Paginator->sort('start_date_time', __('Start Date-Time')); ?></th>
                    <th><?php echo $this->Paginator->sort('end_date_time', __('End Date-Time')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php if ($trainings) {
                        $x = 0;
                        foreach ($trainings as $training):
                ?>
                <tr>

                    <td class=" actions">

                        <?php echo $this->element('actions', array('created' => $training['Training']['created_by'], 'postVal' => $training['Training']['id'], 'softDelete' => $training['Training']['soft_delete'])); ?>

                    </td>
                    <td><?php echo $training['Training']['title']; ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($training['Course']['title'], array('controller' => 'courses', 'action' => 'view', $training['Course']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($training['Trainer']['name'], array('controller' => 'trainers', 'action' => 'view', $training['Trainer']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($training['TrainerType']['title'], array('controller' => 'trainer_types', 'action' => 'view', $training['TrainerType']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($training['CourseType']['title'], array('controller' => 'course_types', 'action' => 'view', $training['CourseType']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $training['Training']['Attendees']; ?>
                    </td>
                    <td><?php echo $training['Training']['start_date_time']; ?>&nbsp;</td>
                    <td><?php echo $training['Training']['end_date_time']; ?>&nbsp;</td>
                    <td><?php echo h($training['PreparedBy']['name']); ?>&nbsp;</td>
                    <td><?php echo h($training['ApprovedBy']['name']); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($training['Training']['publish'] == 1) { ?>
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
                <tr><td colspan=20><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "description" => "Description", "start_date_time" => "Start Date Time", "end_date_time" => "End Date Time"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "description" => "Description", "start_date_time" => "Start Date Time", "end_date_time" => "End Date Time"))); ?>
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