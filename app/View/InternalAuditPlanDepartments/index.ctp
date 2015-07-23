<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="internalAuditPlanDepartments ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Internal Audit Plan Departments', 'modelClass' => 'InternalAuditPlanDepartment', 'options' => array("sr_no" => "Sr No"), 'pluralVar' => 'internalAuditPlanDepartments'))); ?>

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
                    <th><?php echo $this->Paginator->sort('internal_audit_plan_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('department_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('employee_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('list_of_trained_internal_auditor_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($internalAuditPlanDepartments) {
                        $x = 0;
                        foreach ($internalAuditPlanDepartments as $internalAuditPlanDepartment):
                ?>
                <tr>

                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $internalAuditPlanDepartment['InternalAuditPlanDepartment']['created_by'], 'postVal' => $internalAuditPlanDepartment['InternalAuditPlanDepartment']['id'], 'softDelete' => $internalAuditPlanDepartment['InternalAuditPlanDepartment']['soft_delete'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($internalAuditPlanDepartment['InternalAuditPlan']['title'], array('controller' => 'internal_audit_plans', 'action' => 'view', $internalAuditPlanDepartment['InternalAuditPlan']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($internalAuditPlanDepartment['Department']['name'], array('controller' => 'departments', 'action' => 'view', $internalAuditPlanDepartment['Department']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($internalAuditPlanDepartment['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $internalAuditPlanDepartment['Employee']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($internalAuditPlanDepartment['ListOfTrainedInternalAuditor']['id'], array('controller' => 'list_of_trained_internal_auditors', 'action' => 'view', $internalAuditPlanDepartment['ListOfTrainedInternalAuditor']['id'])); ?>
                    </td>
                    <td><?php echo h($PublishedEmployeeList[$internalAuditPlanDepartment['InternalAuditPlanDepartment']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$internalAuditPlanDepartment['InternalAuditPlanDepartment']['approved_by']]); ?>&nbsp;</td>

                    <td width="60">
                        <?php if ($internalAuditPlanDepartment['InternalAuditPlanDepartment']['publish'] == 1) { ?>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No"))); ?>
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