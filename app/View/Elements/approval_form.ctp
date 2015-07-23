<?php
    $modelName = Inflector::singularize($this->name);
    if (isset($this->data['CreatedBy']['username']))
        $approversList[$this->data[$modelName]['created_by']] = $this->data['CreatedBy']['name'] . " (" . $this->data['CreatedBy']['username'] . ")";
?>
<?php if($this->request->params['controller'] == 'internal_audit_plans'){?>
<div class =row>
    <div class = "col-md-6"><?php echo $this->Form->input('prepared_by', array('options' => $PublishedEmployeeList,'default'=>$internalAuditPlan['InternalAuditPlan']['prepared_by'])); ?></div>
    <div class = "col-md-6"><?php echo $this->Form->input('approved_by', array('options' => $PublishedEmployeeList,'default'=>$internalAuditPlan['InternalAuditPlan']['approved_by'])); ?></div>
</div>
<?php }else{?>
<div class =row>
    <div class = "col-md-6"><?php echo $this->Form->input('prepared_by', array('options' => $PublishedEmployeeList,'default'=>$this->Session->read('User.employee_id'))); ?></div>
    <div class = "col-md-6"><?php echo $this->Form->input('approved_by', array('options' => $PublishedEmployeeList)); ?></div>
</div>
<?php }?>
<div class="clearfix">&nbsp;</div>
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title"><?php echo __("Auto Approval Process") ?> <small>Available in latest version</small></h3></div>

    <div class="panel-body">
        <?php echo __("Send appended records for approval to the relevant approving authority from the given list.") ?>
        <?php if (isset($approversList))  ?>
        <?php echo $this->Form->input('Approval.user_id', array('disabled' ,'options' => $approversList)); ?>
        <?php echo $this->Form->input('Approval.comments', array('disabled' , 'type' => 'textarea')); ?>
    </div>
    <?php if (isset($showApprovals['show_publish']) && $showApprovals['show_publish'] == true) { ?>
        <div class="panel-footer">
            <h5>
                <?php echo $this->Form->input('publish', array('label' => __('Publish Now.'))); ?>
            </h5>
            <span class="help-block"><?php echo __('Check the checkbox above to publish the record without sending for any approvals.'); ?></span>
        </div>
    <?php } ?>
</div>
<?php if (isset($approvalHistory) && isset($approvalHistory['History'])) echo $this->element("approval_history"); ?>

