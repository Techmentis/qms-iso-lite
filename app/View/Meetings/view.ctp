<div id="meetings_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="meetings form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Meeting'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($meeting['Meeting']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Title'); ?></td>
                    <td>
                        <?php echo h($meeting['Meeting']['title']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Previous Meeting'); ?></td>
                    <td>
                        <?php echo h($meeting['Meeting']['previous_meeting_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Meeting Scheduled From'); ?></td>
                    <td>
                        <?php echo h($meeting['Meeting']['scheduled_meeting_from']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Meeting Scheduled To'); ?></td>
                    <td>
                        <?php echo h($meeting['Meeting']['scheduled_meeting_to']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Meeting Details'); ?></td>
                    <td>
                        <?php echo h($meeting['Meeting']['meeting_details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Invitees'); ?></td>
                    <td>
                        <?php echo h($meeting['Meeting']['Invitees']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Chairperson'); ?></td>
                    <td>
                        <?php echo h($meeting['Meeting']['employee_by']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo h($meeting['Meeting']['Branches']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo h($meeting['Meeting']['Departments']); ?>
                        &nbsp;
                    </td>
                </tr>
                <?php if (strtotime($meeting['Meeting']['actual_meeting_from']) >= strtotime($meeting['Meeting']['scheduled_meeting_from'])) { ?>
                    <tr><td><?php echo __('Meeting Actual From'); ?></td>
                        <td>
                            <?php echo $meeting['Meeting']['actual_meeting_from'] != '0000-00-00 00:00:00' ? $meeting['Meeting']['actual_meeting_from'] : ''; ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr><td><?php echo __('Meeting Actual To'); ?></td>
                        <td>
                            <?php echo $meeting['Meeting']['actual_meeting_to'] != '0000-00-00 00:00:00' ? $meeting['Meeting']['actual_meeting_to'] : '';?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr><td><?php echo __('Attendees'); ?></td>
                        <td>
                            <?php echo h($meeting['Meeting']['Attendees']); ?>
                            &nbsp;
                        </td>
                    </tr>
                <?php } ?>

                    <tr><td><?php echo __('Prepared By'); ?></td>
                        <td>
                            <?php echo h($meeting['PreparedBy']['name']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr><td><?php echo __('Approved By'); ?></td>
                        <td>
                            <?php echo h($meeting['ApprovedBy']['name']); ?>
                            &nbsp;
                        </td>
                    </tr>

                    <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($meeting['Meeting']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>

            <table class="table table-responsive">
                <?php $i = 1; ?>
                <?php foreach ($meetingTopics as $meetingTopic) { ?>
                    <tr><td colspan=2><h4><?php echo __('Meeting Topics') . " " . $i; ?></h4></td></tr>
                    <tr><td>
                            <?php echo __('Topic'); ?>
                        </td>
                        <td>
                            <?php echo h($meetingTopic['MeetingTopic']['title']); ?>
                        </td>
                    </tr>
                    <tr><td>
                            <?php echo __('Current Status'); ?>
                        </td>
                        <td>
                            <?php echo h($meetingTopic['MeetingTopic']['current_status']) ?>
                        </td>
                    </tr>
                    <tr><td>
                            <?php echo __('Action Plan'); ?>
                        </td>
                        <td>
                            <?php echo h($meetingTopic['MeetingTopic']['action_plan']) ?>
                        </td>
                    </tr>
                    <tr><td>
                            <?php echo __('Responsibility'); ?>
                        </td>
                        <td>
                            <?php echo h($meetingTopic['Employee']['name']) ?>
                        </td>
                    </tr>
                    <tr><td>
                            <?php echo __('Target Date'); ?>
                        </td>
                        <td>
                            <?php echo h($meetingTopic['MeetingTopic']['target_date']) ?>
                        </td>
                    </tr>
                <?php $i++; } ?>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $meeting['Meeting']['created_by'], 'recordId' => $meeting['Meeting']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#meetings_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $meeting['Meeting']['id'], 'ajax'), array('async' => true, 'update' => '#meetings_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#meetings_ajax'))); ?>
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