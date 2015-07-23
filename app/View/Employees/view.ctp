    <div id="employees_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="employees form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Employee'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><strong><?php echo __('Name'); ?></strong></td>
                    <td>
                        <?php echo $employee['Employee']['name']; ?>
                        &nbsp;
                    </td>
                    <td><strong><?php echo __('Employee Number'); ?></strong></td>
                    <td>
                        <?php echo $employee['Employee']['employee_number']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><strong><?php echo __('Branch'); ?></strong></td>
                    <td>
                        <?php echo $this->Html->link($employee['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $employee['Branch']['id'])); ?>
                        &nbsp;
                    </td>
                    <td><strong><?php echo __('Designation'); ?></strong></td>
                    <td>
                        <?php echo $this->Html->link($employee['Designation']['name'], array('controller' => 'designations', 'action' => 'view', $employee['Designation']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><strong><?php echo __('Joining Date'); ?></strong></td>
                    <td>
                        <?php echo $employee['Employee']['joining_date']; ?>
                        &nbsp;
                    </td>
                    <td><strong><?php echo __('Date Of Birth'); ?></strong></td>
                    <td>
                        <?php echo $employee['Employee']['date_of_birth']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><strong><?php echo __('Pancard Number'); ?></strong></td>
                    <td>
                        <?php echo $employee['Employee']['pancard_number']; ?>
                        &nbsp;
                    </td>
                    <td><strong><?php echo __('Personal Telephone'); ?></strong></td>
                    <td>
                        <?php echo $employee['Employee']['personal_telephone']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><strong><?php echo __('Office Telephone'); ?></strong></td>
                    <td>
                        <?php echo $employee['Employee']['office_telephone']; ?>
                        &nbsp;
                    </td>
                    <td><strong><?php echo __('Mobile'); ?></strong></td>
                    <td>
                        <?php echo $employee['Employee']['mobile']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><strong><?php echo __('Personal Email'); ?></strong></td>
                    <td>
                        <?php echo $employee['Employee']['personal_email']; ?>
                        &nbsp;
                    </td>
                    <td><strong><?php echo __('Office Email'); ?></strong></td>
                    <td>
                        <?php echo $employee['Employee']['office_email']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><strong><?php echo __('Residence Address'); ?></strong></td>
                    <td>
                        <?php echo $employee['Employee']['residence_address']; ?>
                        &nbsp;
                    </td>
                    <td><strong><?php echo __('Permanent Address'); ?></strong></td>
                    <td>
                        <?php echo $employee['Employee']['permenant_address']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><strong><?php echo __('Marital Status'); ?></strong></td>
                    <td>
                        <?php
                        if ($employee['Employee']['maritial_status'] != -1)
                            echo $employee['Employee']['maritial_status'];
                        else
                            echo '';
                        ?>
                        &nbsp;
                    </td>
                    <td><strong><?php echo __('Driving License'); ?></strong></td>
                    <td>
                        <?php echo $employee['Employee']['driving_license']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><strong><?php echo __('Qualification');?></strong></td>
		    <td>
			<?php echo $employee['Employee']['qualification'];?>
		    </td>
		    <td><strong><?php echo __('Employment Status'); ?></strong></td>
		    <td>
			<?php echo $employee['Employee']['employment_status'] ? __('Active') : __('Resigned'); ?>
			&nbsp;
		    </td>
		</tr>
                <tr><td><strong><?php echo __('Prepared By');?></strong></td>
		    <td>
			<?php echo h($employee['PreparedBy']['name']);?>
		    </td>
		    <td><strong><?php echo __('Approved By'); ?></strong></td>
		    <td>
			<?php echo h($employee['ApprovedBy']['name']); ?>
			&nbsp;
		    </td>
		</tr>
		<tr>
		    <td><strong><?php echo __('Publish'); ?></strong></td>
                    <td>
                        <?php if ($employee['Employee']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $employee['Employee']['created_by'], 'recordId' => $employee['Employee']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="main_kra">
        <?php echo $this->element('add_kra'); ?>
    </div>
    <?php echo $this->element('etni'); ?>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#employees_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $employee['Employee']['id'], 'ajax'), array('async' => true, 'update' => '#employees_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#employees_ajax'))); ?>
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
