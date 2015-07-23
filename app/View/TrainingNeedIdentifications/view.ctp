<div id="trainingNeedIdentifications_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="trainingNeedIdentifications form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Training Need Identification'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Course'); ?></td>
                    <td>
                        <?php echo $this->Html->link($trainingNeedIdentification['Course']['title'], array('controller' => 'courses', 'action' => 'view', $trainingNeedIdentification['Course']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Remarks'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['TrainingNeedIdentification']['remarks']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Schedule'); ?></td>
                    <td>
                        <?php echo $this->Html->link($trainingNeedIdentification['Schedule']['name'], array('controller' => 'schedules', 'action' => 'view', $trainingNeedIdentification['Schedule']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($trainingNeedIdentification['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($trainingNeedIdentification['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($trainingNeedIdentification['TrainingNeedIdentification']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>

            <h4><?php echo __('Employee Details'); ?></h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Name'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['Employee']['name']; ?>
                        &nbsp;
                    </td><td><?php echo __('Employee Number'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['Employee']['employee_number']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($trainingNeedIdentification['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $trainingNeedIdentification['BranchIds']['id'])); ?>
                        &nbsp;
                    </td><td><?php echo __('Designation'); ?></td>
                    <td>
                        <?php echo h($trainingNeedIdentification['Designation']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Joining Date'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['Employee']['joining_date']; ?>
                        &nbsp;
                    </td><td><?php echo __('Date Of Birth'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['Employee']['date_of_birth']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Pancard Number'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['Employee']['pancard_number']; ?>
                        &nbsp;
                    </td><td><?php echo __('Personal Telephone'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['Employee']['personal_telephone']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Office Telephone'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['Employee']['office_telephone']; ?>
                        &nbsp;
                    </td><td><?php echo __('Mobile'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['Employee']['mobile']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Personal Email'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['Employee']['personal_email']; ?>
                        &nbsp;
                    </td><td><?php echo __('Office Email'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['Employee']['office_email']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Residence Address'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['Employee']['residence_address']; ?>
                        &nbsp;
                    </td><td><?php echo __('Permanent Address'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['Employee']['permenant_address']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Marital Status'); ?></td>
                    <td>
                        <?php
                        if ($trainingNeedIdentification['Employee']['maritial_status'] != -1)
                            echo $trainingNeedIdentification['Employee']['maritial_status'];
                        else
                            echo '';
                        ?>
                        &nbsp;
                    </td><td><?php echo __('Driving License'); ?></td>
                    <td>
                        <?php echo $trainingNeedIdentification['Employee']['driving_license']; ?>
                        &nbsp;
                    </td>
                </tr>
            </table>
            <h4><?php echo __('Trainings Attended'); ?></h4>

            <table class="table table-responsive">
                <tr>
                    <th><?php echo __('Course') ?></th>
                    <th><?php echo __('Training Details') ?></th>
                    <th><?php echo __('Training date') ?></th>
                </tr>
                <?php
                    foreach ($trainings as $training):
                        if ($training) {
                ?>
                <tr <?php if ($training['Course']['id'] == $trainingNeedIdentification['Course']['id']) echo 'class="success"'; ?>>
                    <td><strong><?php echo $training['Course']['title'] ?></strong></td>
                    <td><?php echo $training['Training']['title'] ?><br /><?php echo $training['Training']['description'] ?></td>
                    <td><?php echo date('Y-m-d', strtotime($training['Training']['start_date_time'])) ?></td>
                </tr>
                <?php } endforeach ?>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $trainingNeedIdentification['TrainingNeedIdentification']['created_by'], 'recordId' => $trainingNeedIdentification['TrainingNeedIdentification']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#trainingNeedIdentifications_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $trainingNeedIdentification['TrainingNeedIdentification']['id'], 'ajax'), array('async' => true, 'update' => '#trainingNeedIdentifications_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#trainingNeedIdentifications_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

<script>
    $.ajaxSetup({
        beforeSend: function () {
            $("#busy-indicator").show();
        },
        complete: function () {
            $("#busy-indicator").hide();
        }
    });
</script>
