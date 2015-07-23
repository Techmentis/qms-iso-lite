
<script>
<?php
    if (!empty($capa_type)) { ?>
        $('#search.capa_type') = <?php
        echo $capa_type;
    }
?>;
</script>
<?php echo $this->element('checkbox-script'); ?>
<div  id="main">
    <div id ="capa_main_inner">
        <?php echo $this->Session->flash(); ?>
        <div class="correctivePreventiveActions " style="padding: 20px">
            <?php echo $this->Html->link('Search', array('action' => '#capa_advanced_search_modal'), array('id' => 'ad_src', 'class' => 'btn btn-info pull-right', 'data-toggle' => 'modal', 'data-original-title' => 'Advanced Search', 'style' => 'margin-top:25px;margin-right:10px;padding-left:20px;padding-right:20px;')); ?>
            <?php echo $this->element('capa_navigation', array('postData' => array('pluralHumanName' => 'Corrective Preventive Actions', 'modelClass' => 'CorrectivePreventiveAction', 'options' => array("sr_no" => "Sr No", "number" => "Number", "raised_by" => "Raised By", "assigned_to" => "Assigned To", "target_date" => "Target Date", "initial_remarks" => "Initial Remarks", "proposed_immidiate_action" => "Proposed Immediate Action", "completed_by" => "Completed By", "completed_on_date" => "Completed On Date", "completion_remarks" => "Completion Remarks", "root_cause_analysis_required" => "Root Cause Analysis Required", "root_cause" => "Root Cause", "determined_by" => "Determined By", "determined_on_date" => "Determined On Date", "root_cause_remarks" => "Root Cause Remarks", "proposed_longterm_action" => "Proposed Longterm Action", "action_assigned_to" => "Action Assigned To", "action_completed_on_date" => "Action Completed On Date", "action_completion_remarks" => "Action Completion Remarks", "effectiveness" => "Effectiveness", "closed_by" => "Closed By", "closed_on_date" => "Closed On Date", "closure_remarks" => "Closure Remarks", "document_changes_required" => "Document Changes Required"), 'pluralVar' => 'correctivePreventiveActions'))); ?>

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
                        <th><?php echo $this->Paginator->sort('number', __('CAPA Number')); ?></th>
                        <th><?php echo $this->Paginator->sort('capa_source_id', __('CAPA Source')); ?></th>
                        <th><?php echo $this->Paginator->sort('capa_category_id', __('CAPA Category')); ?></th>
                        <th><?php echo $this->Paginator->sort('raised_by', __('Raised By')); ?></th>
                        <th><?php echo $this->Paginator->sort('assigned_to', __('Assigned To')); ?></th>
                        <th><?php echo $this->Paginator->sort('target_date', __('Target Date')); ?></th>
                        <th><?php echo $this->Paginator->sort('action_assigned_to', __('Action Assigned to')); ?></th>
                        <th><?php echo $this->Paginator->sort('action_completed_on_date', __('Action Completed on Date')); ?></th>
                        <th><?php echo $this->Paginator->sort('closed_by', __('Closed By')); ?></th>
                        <th><?php echo $this->Paginator->sort('closed_on_date', __('Closed on Date')); ?></th>
                        <th><?php echo $this->Paginator->sort('document_changes_required', __('Document Changes Required')); ?></th>
                        <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                    </tr>
                    <?php
                        if ($correctivePreventiveActions) {
                            $x = 0;
                        foreach ($correctivePreventiveActions as $correctivePreventiveAction):
                    ?>
                    <tr>
                        <td class=" actions">
                            <?php echo $this->element('actions', array('created' => $correctivePreventiveAction['CorrectivePreventiveAction']['created_by'], 'postVal' => $correctivePreventiveAction['CorrectivePreventiveAction']['id'], 'softDelete' => $correctivePreventiveAction['CorrectivePreventiveAction']['soft_delete'])); ?>
                        </td>
                        <td><?php echo $correctivePreventiveAction['CorrectivePreventiveAction']['name']; ?>&nbsp;</td>
                        <td><?php echo $correctivePreventiveAction['CorrectivePreventiveAction']['number']; ?>&nbsp;</td>
                        <td>
                            <?php echo $this->Html->link($correctivePreventiveAction['CapaSource']['name'], array('controller' => 'capa_sources', 'action' => 'view', $correctivePreventiveAction['CapaSource']['id'])); ?>
                        </td>
                        <td>
                            <?php echo $this->Html->link($correctivePreventiveAction['CapaCategory']['name'], array('controller' => 'capa_categories', 'action' => 'view', $correctivePreventiveAction['CapaCategory']['id'])); ?>
                        </td>
                        <td>
                            <?php
                                $sorce = json_decode($correctivePreventiveAction['CorrectivePreventiveAction']['raised_by'], true);
                                if ($sorce == null)
                                    echo $correctivePreventiveAction['CorrectivePreventiveAction']['raised_by'];
                                else
                                    echo $this->Html->link($sorce['Soruce'], array('controller' => str_replace(' ', '_', Inflector::pluralize($sorce['Soruce'])), 'action' => 'view', $sorce['id']));
                            ?>&nbsp;
                        </td>
                        <td><?php
                            if ($correctivePreventiveAction['CorrectivePreventiveAction']['assigned_to'] != -1)
                                echo $correctivePreventiveAction['AssignedTo']['name'];
                            ?>&nbsp;</td>
                        <td><?php echo $correctivePreventiveAction['CorrectivePreventiveAction']['target_date']; ?>&nbsp;</td>

                        <td><?php
                            if ($correctivePreventiveAction['CorrectivePreventiveAction']['action_assigned_to'] != -1)
                                echo $correctivePreventiveAction['ActionAssignedTo']['name'];
                            ?>&nbsp;</td>
                        <td><?php echo $correctivePreventiveAction['CorrectivePreventiveAction']['action_completed_on_date']; ?>&nbsp;</td>

                        <td><?php
                            if ($correctivePreventiveAction['CorrectivePreventiveAction']['closed_by'] != -1)
                                echo $correctivePreventiveAction['ClosedBy']['name'];
                            ?>&nbsp;</td>
                        <td><?php echo $correctivePreventiveAction['CorrectivePreventiveAction']['closed_on_date']; ?>&nbsp;</td>

                        <td><?php echo $correctivePreventiveAction['CorrectivePreventiveAction']['document_changes_required'] ? __('Yes') : __('No'); ?>&nbsp;</td>

                        <td width="60">
                            <?php if ($correctivePreventiveAction['CorrectivePreventiveAction']['publish'] == 1) { ?>
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
                    <tr><td colspan=37><?php echo __('No results found'); ?></td></tr>
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
    <?php echo $this->element('capa_advanced_search_modal'); ?>
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "number" => "Number", "raised_by" => "Raised By", "assigned_to" => "Assigned To", "target_date" => "Target Date", "initial_remarks" => "Initial Remarks", "proposed_immidiate_action" => "Proposed Immediate Action", "completed_by" => "Completed By", "completed_on_date" => "Completed On Date", "completion_remarks" => "Completion Remarks", "root_cause_analysis_required" => "Root Cause Analysis Required", "root_cause" => "Root Cause", "determined_by" => "Determined By", "determined_on_date" => "Determined On Date", "root_cause_remarks" => "Root Cause Remarks", "proposed_longterm_action" => "Proposed Longterm Action", "action_assigned_to" => "Action Assigned To", "action_completed_on_date" => "Action Completed On Date", "action_completion_remarks" => "Action Completion Remarks", "effectiveness" => "Effectiveness", "closed_by" => "Closed By", "closed_on_date" => "Closed On Date", "closure_remarks" => "Closure Remarks", "document_changes_required" => "Document Changes Required"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "number" => "Number", "raised_by" => "Raised By", "assigned_to" => "Assigned To", "target_date" => "Target Date", "initial_remarks" => "Initial Remarks", "proposed_immidiate_action" => "Proposed Immediate Action", "completed_by" => "Completed By", "completed_on_date" => "Completed On Date", "completion_remarks" => "Completion Remarks", "root_cause_analysis_required" => "Root Cause Analysis Required", "root_cause" => "Root Cause", "determined_by" => "Determined By", "determined_on_date" => "Determined On Date", "root_cause_remarks" => "Root Cause Remarks", "proposed_longterm_action" => "Proposed Longterm Action", "action_assigned_to" => "Action Assigned To", "action_completed_on_date" => "Action Completed On Date", "action_completion_remarks" => "Action Completion Remarks", "effectiveness" => "Effectiveness", "closed_by" => "Closed By", "closed_on_date" => "Closed On Date", "closure_remarks" => "Closure Remarks", "document_changes_required" => "Document Changes Required"))); ?>
    <?php echo $this->element('approvals'); ?>
    <?php echo $this->element('common'); ?>
</div>
<?php echo $this->Js->writeBuffer(); ?>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>
