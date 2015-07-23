<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<div id="masterListOfFormats_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="masterListOfFormats form col-md-8">
            <h4><?php echo __('Add Master List Of Format'); ?></h4>
            <?php echo $this->Form->create('MasterListOfFormat', array('role' => 'form', 'class' => 'form')); ?>

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
                <div class="col-md-6">
                    <?php echo $this->Form->input('archived'); ?>If the format is old please mark it as "Archived"</p>
                </div>

                <?php
                    echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id')));
                    echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id')));
                ?>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Js->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#masterListOfFormats_ajax', 'async' => 'false')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
</div>

<script>
    $("[name*='date']").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
    });
</script>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>