<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[Proposal][customer_id]' ||
                $(element).attr('name') == 'data[Proposal][employee_id]')
                $(element).next().after(error);
            else {
                $(element).after(error);
            }
        }
    });

    $().ready(function () {

        jQuery.validator.addMethod("notEqual", function (value, element, param) {
            return this.optional(element) || value != param;
        }, "Please select the value");

        $('#ProposalApproveForm').validate({
            rules: {
                "data[Proposal][customer_id]": {
                    notEqual: -1,
                },
                "data[Proposal][employee_id]": {
                    notEqual: -1,
                },
            }
        });
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#ProposalApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#ProposalApproveForm").submit();
             }

        });
        $('#ProposalCustomerId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#ProposalEmployeeId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="proposals_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="proposals form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Proposal'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('Proposal', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('title'); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('customer_id'); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('employee_id'); ?></div>
                <?php
                    if ($this->request->data['Proposal']['active_lock'] == 1) {
                        $checked = true;
                    } else {
                        $checked = false;
                    }
                ?>
                <div class="col-md-6"><?php echo $this->Form->input('proposal_date'); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('active_lock', array('type' => 'checkbox', 'label' => __('Restrict access?'), 'checked' => $checked)); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('proposal_heading'); ?></div>
                <div class="col-md-12">
                    <?php echo $this->Form->input('proposal_details'); ?>
                    <span class="help-text"><?php echo __('You can copy and paste your existing proposal here. You can also upload your proposal after saving this record'); ?></span>
                </div>
                <div class="col-md-6"><?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?></div>
                </row>
            </div>
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
    }).attr('readonly','readonly');
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#proposals_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>