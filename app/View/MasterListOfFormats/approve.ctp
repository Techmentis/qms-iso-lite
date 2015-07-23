<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[MasterListOfFormat][prepared_by]' ||
                    $(element).attr('name') == 'data[MasterListOfFormat][approved_by]' ||
                    $(element).attr('name') == 'data[MasterListOfFormat][system_table_id]' ||
                    $(element).attr('name') == 'MasterListOfFormatBranch.branch_id[]' ||
                    $(element).attr('name') == 'MasterListOfFormatDepartment.department_id[]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
    });

    $().ready(function() {
        jQuery.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#MasterListOfFormatApproveForm').validate({
            rules: {
                "data[MasterListOfFormat][prepared_by]": {
                    greaterThanZero: true,
                },
                "data[MasterListOfFormat][approved_by]": {
                    greaterThanZero: true,
                },
                "data[MasterListOfFormat][system_table_id]": {
                    greaterThanZero: true,
                },
                "MasterListOfFormatBranch.branch_id[]": {
                    greaterThanZero: true,
                    required: true,
                },
                "MasterListOfFormatDepartment.department_id[]": {
                    greaterThanZero: true,
                    required: true,
                },
            }
        });
            $("#submit-indicator").hide();
            $("#submit_id").click(function(){
             if($('#MasterListOfFormatApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#MasterListOfFormatApproveForm").submit();
             }

        });
        $('#MasterListOfFormatPreparedBy').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#MasterListOfFormatApprovedBy').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#MasterListOfFormatSystemTableId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#MasterListOfFormatBranchBranchId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#MasterListOfFormatDepartmentDepartmentId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="masterListOfFormats_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="masterListOfFormats form col-md-8">
            <h4><?php echo __('Approve Master List Of Format'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('MasterListOfFormat', array('role' => 'form', 'class' => 'form')); ?>
            <fieldset>
                <div class="row">
                    <div class="col-md-8"><?php echo $this->Form->input('title'); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('document_number'); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('issue_number'); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('revision_number'); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('revision_date'); ?></div>
                    <div class="col-md-12"><?php echo $this->Form->input('work_instructions'); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('MasterListOfFormatBranch.branch_id', array('name' => 'MasterListOfFormatBranch.branch_id[]', 'type' => 'select', 'multiple', 'options' => $PublishedBranchList, 'style' => 'width:100%', 'default' => $selected_branches)); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('MasterListOfFormatDepartment.department_id', array('name' => 'MasterListOfFormatDepartment.department_id[]', 'type' => 'select', 'multiple', 'options' => $PublishedDepartmentList, 'style' => 'width:100%', 'default' => $selected_depts)); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('prepared_by', array('options' => $prepared_by, 'style' => 'width:100%')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('approved_by', array('options' => $prepared_by, 'style' => 'width:100%')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('system_table_id'); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('archived'); ?>If the format is old please mark it as "Archived"</div>
                    <div class="col-md-6">
                        <?php echo $this->Html->link('View Records', array('controller' => $this->data['SystemTable']['system_name']), array('class' => 'btn btn-info')); ?>
                    </div>
                </div>

                <?php
                    if ($showApprovals && $showApprovals['show_panel'] == true) {
                        echo $this->element('approval_form');
                    } else {
                        echo $this->Form->input('publish', array('label' => __('Publish')));
                    }
                ?>
                <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
                <?php echo $this->Form->end(); ?>
                <?php echo $this->Js->writeBuffer(); ?>
            </fieldset>
        </div>

<script>
    $("[name*='date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#masterListOfFormats_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>
