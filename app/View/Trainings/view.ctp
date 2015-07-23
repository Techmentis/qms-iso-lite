<div id="trainings_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="trainings form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Training'); ?>&nbsp;
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo $training['Training']['sr_no']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Title'); ?></td>
                    <td>
                        <?php echo $training['Training']['title']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Training Details'); ?></td>
                    <td>
                        <?php echo $training['Training']['description']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Course'); ?></td>
                    <td>
                        <?php echo $this->Html->link($training['Course']['title'], array('controller' => 'courses', 'action' => 'view', $training['Course']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Trainer'); ?></td>
                    <td>
                        <?php echo $this->Html->link($training['Trainer']['name'], array('controller' => 'trainers', 'action' => 'view', $training['Trainer']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Trainer Type'); ?></td>
                    <td>
                        <?php echo $this->Html->link($training['TrainerType']['title'], array('controller' => 'trainer_types', 'action' => 'view', $training['TrainerType']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Course Type'); ?></td>
                    <td>
                        <?php echo $this->Html->link($training['CourseType']['title'], array('controller' => 'course_types', 'action' => 'view', $training['CourseType']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Attendees'); ?></td>
                    <td>
                        <?php echo($attendees); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Start Date Time'); ?></td>
                    <td>
                        <?php echo $training['Training']['start_date_time']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('End Date Time'); ?></td>
                    <td>
                        <?php echo $training['Training']['end_date_time']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($training['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($training['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($training['Training']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $training['Training']['created_by'], 'recordId' => $training['Training']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#trainings_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $training['Training']['id'], 'ajax'), array('async' => true, 'update' => '#trainings_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#trainings_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>
