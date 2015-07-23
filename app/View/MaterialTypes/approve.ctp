<script>
    $.ready(function(){
       $("#MaterialTypeApproveForm").validate();
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#MaterialTypeApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#MaterialTypeApproveForm").submit();
             }

        });
    });
</script>
<div id="materialTypes_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel">
        <div class="materialTypes form col-md-8">
            <h4><?php echo __('Approve Material Type'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('MaterialType', array('role' => 'form', 'class' => 'form')); ?>
            <div class="col-md-6"><?php echo $this->Form->input('id'); ?></div>
            <div class="col-md-6"><?php echo $this->Form->input('name'); ?></div>
            <div class="col-md-6"><?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?></div>
            <div class="col-md-6"><?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?></div>
            <div class="col-md-6"><?php echo $this->Form->input('company_id'); ?></div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish');
                }
            ?>
            <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>

<script>
    $("[name*='date']").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
    });
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
</div>

<?php $this->Js->get('#list'); ?>
<?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#materialTypes_ajax'))); ?>
<?php echo $this->Js->writeBuffer(); ?>

<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Import from file (excel & csv formats only)</h4>
            </div>
            <div class="modal-body"><?php echo $this->element('import'); ?></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
