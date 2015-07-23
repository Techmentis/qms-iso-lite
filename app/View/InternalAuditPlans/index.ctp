<?php echo $this->element('checkbox-script'); ?>
<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="internalAuditPlans ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Internal Audit Plans', 'modelClass' => 'InternalAuditPlan', 'options' => array("sr_no" => "Sr No", "title" => "Title", "audit_date" => "Audit Date", "clauses" => "Clauses", "audit_from" => "Audit From", "audit_to" => "Audit To", "note" => "Note"), 'pluralVar' => 'internalAuditPlans'))); ?>

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
                    <th><?php echo __('Title'); ?></th>
                    <th><?php echo __('Details'); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($internalAuditPlans) {
                        $x = 0;
                        foreach ($internalAuditPlans as $internalAuditPlan):
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $internalAuditPlan['InternalAuditPlan']['created_by'], 'postVal' => $internalAuditPlan['InternalAuditPlan']['id'], 'softDelete' => $internalAuditPlan['InternalAuditPlan']['soft_delete'])); ?>
                    </td>
                    <td>
                        <b><?php echo (__('Title') . ' : '); ?></b><?php echo $internalAuditPlan['InternalAuditPlan']['title']; ?><br />
                        <b><?php echo (__('Scheduled From') . ' : '); ?></b><?php echo $internalAuditPlan['InternalAuditPlan']['schedule_date_from']; ?><br />
                        <b><?php echo (__('Scheduled To') . ' : '); ?></b><?php echo $internalAuditPlan['InternalAuditPlan']['schedule_date_to']; ?><br />
                        <b><?php echo (__('Branch To be audited') . ' : '); ?></b>
                        <?php
                        foreach ($internalAuditPlan['InternalAuditPlanBranch'] as $branch):
                            echo $branch['Branch']['name'] . ", ";
                        endforeach;
                        ?>
                        <br />

                        <b><?php echo (__('Departments') . ' : '); ?></b>
                        <?php
                        foreach ($internalAuditPlan['InternalAuditPlanDepartment'] as $department):
                            echo $department['Department']['name'] . ", ";
                        endforeach;
                        ?>
                        <br />
                        <b><?php echo (__('Auditor') . ' : '); ?><?php echo $internalAuditPlan['ListOfTrainedInternalAuditor']['id'] ?></b>
                    </td>
                    <td>
                        <div class="btn-group-vertical">
                            <?php echo $this->Html->link(__('Edit this Plan'), array('controller' => 'internal_audit_plans', 'action' => 'edit', $internalAuditPlan['InternalAuditPlan']['id']), array('class' => 'btn btn-sm btn-default')); ?>
                            <?php echo $this->Html->link(__('Add Plan Details'), array('controller' => 'internal_audit_plans', 'action' => 'lists', $internalAuditPlan['InternalAuditPlan']['id']), array('class' => 'btn btn-sm btn-default')); ?>
                            <?php if (count($internalAuditPlan['InternalAuditPlanDepartment'])) { ?>
                                <?php echo $this->Html->link(__('Publish'), array('controller' => 'internal_audit_plans', 'action' => 'view', $internalAuditPlan['InternalAuditPlan']['id']), array('class' => 'btn btn-sm btn-default')); ?>
                            <?php } else { ?>
                                <?php echo $this->Html->link(__('Publish'), array('controller' => 'internal_audit_plans', 'action' => 'view', $internalAuditPlan['InternalAuditPlan']['id']), array('class' => 'btn btn-sm btn-default', 'disabled' => true)); ?>
                            <?php } ?>
                            <?php if (strtotime($internalAuditPlan['InternalAuditPlan']['schedule_date_from']) <= strtotime(date('Y-m-d H:i:s'))) { ?>
                                <?php echo $this->Html->link(__('Add Actual Audit Details'), array('controller' => 'internal_audits', 'action' => 'lists', $internalAuditPlan['InternalAuditPlan']['id']), array('class' => 'btn btn-sm btn-default')); ?>
                            <?php } else { ?>
                                <?php echo $this->Html->link(__('Add Actual Audit Details'), array('controller' => 'internal_audits', 'action' => 'lists', $internalAuditPlan['InternalAuditPlan']['id']), array('class' => 'btn btn-sm btn-default', 'disabled' => true)); ?>
                            <?php } ?>

                        </div>
                    </td>
                    <td><?php echo h($PublishedEmployeeList[$internalAuditPlan['InternalAuditPlan']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$internalAuditPlan['InternalAuditPlan']['approved_by']]); ?>&nbsp;</td>
                    <td width="60" >
                        <?php if ($internalAuditPlan['InternalAuditPlan']['publish'] == 1) { ?>
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
                <tr><td colspan=19><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "audit_date" => "Audit Date", "clauses" => "Clauses", "audit_from" => "Audit From", "audit_to" => "Audit To", "note" => "Note"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "audit_date" => "Audit Date", "clauses" => "Clauses", "audit_from" => "Audit From", "audit_to" => "Audit To", "note" => "Note"))); ?>
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