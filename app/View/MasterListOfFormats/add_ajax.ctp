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
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_ajax",
                type: 'POST',
                target: '#main',
                beforeSend: function(){
                   $("#submit_id").prop("disabled",true);
                    $("#submit-indicator").show();
                },
                complete: function() {
                   $("#submit_id").removeAttr("disabled");
                   $("#submit-indicator").hide();
                },
                error: function(request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
            });
        }
    });

    $().ready(function() {
        $("#submit-indicator").hide();
        jQuery.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#MasterListOfFormatAddAjaxForm').validate({
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
    <div class="nav">
        <div class="masterListOfFormats form col-md-8">
            <h4><?php echo __('Add Master List Of Format'); ?></h4>
            <?php echo $this->Form->create('MasterListOfFormat', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
                <div class="col-md-8"><?php echo $this->Form->input('title'); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('document_number'); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('issue_number'); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('revision_number'); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('revision_date'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('MasterListOfFormatBranch.branch_id', array('name' => 'MasterListOfFormatBranch.branch_id[]', 'type' => 'select', 'multiple', 'options' => $PublishedBranchList, 'style' => 'width:100%')); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('MasterListOfFormatDepartment.department_id', array('name' => 'MasterListOfFormatDepartment.department_id[]', 'type' => 'select', 'multiple', 'options' => $PublishedDepartmentList, 'style' => 'width:100%')); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('prepared_by', array('options' => $prepared_by, 'style' => 'width:100%')); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('approved_by', array('options' => $prepared_by, 'style' => 'width:100%')); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('system_table_id'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('archived'); ?> If the format is old please mark it as "Archived"</div>
                <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#masterListOfFormats_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
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
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>