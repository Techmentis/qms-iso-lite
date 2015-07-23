<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <?php
        echo $this->Form->create('Report', array('action' => 'nc_report_excel', 'class' => 'no-padding no-margin pull-right'));
        echo $this->Form->hidden('from', array('value' => $this->request->data['reports']['from']));
        echo $this->Form->hidden('to', array('value' => $this->request->data['reports']['to']));
        echo $this->Form->submit('Export', array('class' => 'btn btn-info pull-right', 'style' => 'margin-top:25px;margin-bottom:25px;margin-right:10px;padding-left:20px;padding-right:20px;'));
        echo $this->Form->end();
    ?>
    <div class="correctivePreventiveActions ">
        <?php echo $this->element('nav-header-lists-reports', array('postData' => array('pluralHumanName' => 'Corrective Preventive Actions', 'modelClass' => 'CorrectivePreventiveAction', 'options' => array("sr_no" => "Sr No", "number" => "Number", "raised_by" => "Raised By", "assigned_to" => "Assigned To", "target_date" => "Target Date", "initial_remarks" => "Initial Remarks", "proposed_immidiate_action" => "Proposed Immediate Action", "completed_by" => "Completed By", "completed_on_date" => "Completed On Date", "completion_remarks" => "Completion Remarks", "root_cause_analysis_required" => "Root Cause Analysis Required", "root_cause" => "Root Cause", "determined_by" => "Determined By", "determined_on_date" => "Determined On Date", "root_cause_remarks" => "Root Cause Remarks", "proposed_longterm_action" => "Proposed Longterm Action", "action_assigned_to" => "Action Assigned To", "action_completed_on_date" => "Action Completed On Date", "action_completion_remarks" => "Action Completion Remarks", "effectiveness" => "Effectiveness", "closed_by" => "Closed By", "closed_on_date" => "Closed On Date", "closure_remarks" => "Closure Remarks", "document_changes_required" => "Document Changes Required"), 'pluralVar' => 'correctivePreventiveActions'))); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#main').load(url);
            return false;
        });
    });
</script>

        <div class="row">
            <div class="col-md-3">
                <div class="alert alert-success report_dashboard_alert">
                    <h3 class="text-success"><?php echo __(' CAPA CLOSED : '); ?><span class="pull-right"><?php echo $capa_closed ?></span></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-danger report_dashboard_alert">
                    <h3 class="text-danger"><?php echo __(' OPEN CAPA : '); ?><span class="pull-right"><?php echo $capa_open ?></span></h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-danger report_dashboard_alert">
                    <h3 class="text-danger"><?php echo __(' ROOT CAUSE ANALYSIS REQUIRED : '); ?><span class="pull-right"><?php echo $capa_root ?></span></h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title"><?php echo __('CAPA by Source'); ?></div>
                    </div>
                    <div class="panel-body">
                        <?php foreach ($capa_source_wise as $key => $value): ?>
                            <h5 class="text-info"><?php echo $key ?><span class="pull-right badge btn-info"><?php echo $value ?></span></span></h5>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <?php echo __('CAPA by Category'); ?>
                        </div></div>
                    <div class="panel-body">
                        <?php foreach ($capa_category_wise as $key => $value): ?>
                            <h5 class="text-info"><?php echo $key ?><span class="pull-right badge btn-info"><?php echo $value ?></span></span></h5>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="table-responsive">
            <?php echo $this->Form->create(array('class' => 'no-padding no-margin no-background')); ?>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th><?php echo __('Number'); ?></th>
                    <th><?php echo __('Source'); ?></th>
                    <th><?php echo __('Category'); ?></th>
                    <th><?php echo __('Raised By'); ?></th>
                    <th><?php echo __('Target Date'); ?></th>
                    <th><?php echo __('Completed on Date'); ?></th>
                    <th><?php echo __('Current Status'); ?></th>
                    <th><?php echo __('Document Changes Required'); ?></th>
                    <th><?php echo __('Root Cause Analysis Required'); ?></th>
                </tr>
                <?php if ($correctivePreventiveActions) {
                    $x = 0;
                    foreach ($correctivePreventiveActions as $correctivePreventiveAction):
                ?>
                <tr>
                    <td><?php echo $correctivePreventiveAction['CorrectivePreventiveAction']['number']; ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($correctivePreventiveAction['CapaSource']['name'], array('controller' => 'capa_sources', 'action' => 'view', $correctivePreventiveAction['CapaSource']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($correctivePreventiveAction['CapaCategory']['name'], array('controller' => 'capa_categories', 'action' => 'view', $correctivePreventiveAction['CapaCategory']['id'])); ?>
                    </td>
                    <td>
                        <?php $sorce = json_decode($correctivePreventiveAction['CorrectivePreventiveAction']['raised_by'], true); ?>&nbsp;
                        <?php echo $this->Html->link($sorce['Soruce'], array('controller' => str_replace(' ', '_', Inflector::pluralize($sorce['Soruce'])), 'action' => 'view', $sorce['id'])); ?>
                    </td>
                    <td><?php echo $correctivePreventiveAction['CorrectivePreventiveAction']['target_date']; ?>&nbsp;</td>
                    <td><?php echo $correctivePreventiveAction['CorrectivePreventiveAction']['completed_on_date']; ?>&nbsp;</td>
                    <td><?php echo $correctivePreventiveAction['CorrectivePreventiveAction']['current_status'] ? __('Close') : __('Open'); ?>&nbsp;</td>
                    <td><?php echo $correctivePreventiveAction['CorrectivePreventiveAction']['document_changes_required'] ? __('Yes') : __('No'); ?>&nbsp;</td>
                    <td><?php echo $correctivePreventiveAction['CorrectivePreventiveAction']['root_cause_analysis_required'] ? __('Yes') : __('No'); ?>&nbsp;</td>
                </tr>
                <?php
                    $x++;
                    endforeach;
                    }else {
                ?>
                    <tr><td colspan=37><?php echo __('No results found'); ?></td></tr>
                <?php } ?>
            </table>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

<script>
    $("document").ready(function() {
        $("#loadGraph").load('nc_report_history')
    });
</script>

<div class="panel panel-info">
    <div class="panel-heading"><h2><?php echo __('Non Conformity History'); ?></h2></div>
    <div class="panel-body">
        <div id="loadGraph">
            <span class="text-danger"><?php echo __('Loading Graph Please Wait...'); ?></span>
        </div>
    </div>
</div>

<?php echo $this->element('export'); ?>
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "number" => "Number", "raised_by" => "Raised By", "assigned_to" => "Assigned To", "target_date" => "Target Date", "initial_remarks" => "Initial Remarks", "proposed_immidiate_action" => "Proposed Immediate Action", "completed_by" => "Completed By", "completed_on_date" => "Completed On Date", "completion_remarks" => "Completion Remarks", "root_cause_analysis_required" => "Root Cause Analysis Required", "root_cause" => "Root Cause", "determined_by" => "Determined By", "determined_on_date" => "Determined On Date", "root_cause_remarks" => "Root Cause Remarks", "proposed_longterm_action" => "Proposed Longterm Action", "action_assigned_to" => "Action Assigned To", "action_completed_on_date" => "Action Completed On Date", "action_completion_remarks" => "Action Completion Remarks", "effectiveness" => "Effectiveness", "closed_by" => "Closed By", "closed_on_date" => "Closed On Date", "closure_remarks" => "Closure Remarks", "document_changes_required" => "Document Changes Required"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "number" => "Number", "raised_by" => "Raised By", "assigned_to" => "Assigned To", "target_date" => "Target Date", "initial_remarks" => "Initial Remarks", "proposed_immidiate_action" => "Proposed Immediate Action", "completed_by" => "Completed By", "completed_on_date" => "Completed On Date", "completion_remarks" => "Completion Remarks", "root_cause_analysis_required" => "Root Cause Analysis Required", "root_cause" => "Root Cause", "determined_by" => "Determined By", "determined_on_date" => "Determined On Date", "root_cause_remarks" => "Root Cause Remarks", "proposed_longterm_action" => "Proposed Longterm Action", "action_assigned_to" => "Action Assigned To", "action_completed_on_date" => "Action Completed On Date", "action_completion_remarks" => "Action Completion Remarks", "effectiveness" => "Effectiveness", "closed_by" => "Closed By", "closed_on_date" => "Closed On Date", "closure_remarks" => "Closure Remarks", "document_changes_required" => "Document Changes Required"))); ?>
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