<?php echo $this->element('checkbox-script'); ?>
<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="employees ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Employees', 'modelClass' => 'Employee', 'options' => array("sr_no" => "Sr No", "name" => "Name", "employee_number" => "Employee Number", "qualification" => "Qualification", "joining_date" => "Joining Date", "date_of_birth" => "Date Of Birth", "pancard_number" => "Pancard Number", "personal_telephone" => "Personal Telephone", "office_telephone" => "Office Telephone", "mobile" => "Mobile", "personal_email" => "Personal Email", "office_email" => "Office Email", "residence_address" => "Residence Address", "permenant_address" => "Permanent Address", "maritial_status" => "Marital Status", "driving_license" => "Driving License"), 'pluralVar' => 'employees'))); ?>

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
                    <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                    <th><?php echo $this->Paginator->sort('branch_id', __('Branch')); ?></th>
                    <th><?php echo $this->Paginator->sort('designation_id', __('Designation')); ?></th>
                    <th><?php echo $this->Paginator->sort('personal_telephone', __('Personal Telephone')); ?></th>
                    <th><?php echo $this->Paginator->sort('office_telephone', __('Office Telephone')); ?></th>
                    <th><?php echo $this->Paginator->sort('mobile', __('Mobile')); ?></th>
                    <th><?php echo $this->Paginator->sort('office_email', __('Office Email')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($employees) {
                        $x = 0;
                        foreach ($employees as $employee):
                ?>
                <tr>

                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $employee['Employee']['created_by'], 'postVal' => $employee['Employee']['id'], 'softDelete' => $employee['Employee']['soft_delete'])); ?>
                    </td>
                    <td><?php echo $employee['Employee']['name']; ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($employee['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $employee['Branch']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($employee['Designation']['name'], array('controller' => 'designations', 'action' => 'view', $employee['Designation']['id'])); ?>
                    </td>
                    <td><?php echo $employee['Employee']['personal_telephone']; ?>&nbsp;</td>
                    <td><?php echo $employee['Employee']['office_telephone']; ?>&nbsp;</td>
                    <td><?php echo $employee['Employee']['mobile']; ?>&nbsp;</td>
                    <td><a href="mailto:<?php echo $employee['Employee']['office_email']; ?>"><?php echo $employee['Employee']['office_email']; ?></a>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$employee['Employee']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$employee['Employee']['approved_by']]); ?>&nbsp;</td>

                    <td width="60">
                        <?php if ($employee['Employee']['publish'] == 1) { ?>
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
                <tr><td colspan=29><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("name" => "Name", "employee_number" => "Employee Number", "qualification" => "Qualification", "joining_date" => "Joining Date", "date_of_birth" => "Date Of Birth", "pancard_number" => "Pancard Number", "personal_telephone" => "Personal Telephone", "office_telephone" => "Office Telephone", "mobile" => "Mobile", "personal_email" => "Personal Email", "office_email" => "Office Email", "residence_address" => "Residence Address", "permenant_address" => "Permanent Address", "maritial_status" => "Marital Status", "driving_license" => "Driving License"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "employee_number" => "Employee Number", "qualification" => "Qualification", "joining_date" => "Joining Date", "date_of_birth" => "Date Of Birth", "pancard_number" => "Pancard Number", "personal_telephone" => "Personal Telephone", "office_telephone" => "Office Telephone", "mobile" => "Mobile", "personal_email" => "Personal Email", "office_email" => "Office Email", "residence_address" => "Residence Address", "permenant_address" => "Permanent Address", "maritial_status" => "Marital Status", "driving_license" => "Driving License"))); ?>
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