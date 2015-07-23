<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[FireExtinguisher][fire_extinguisher_type_id]') {
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

        $('#FireExtinguisherAddAjaxForm').validate({
            rules: {
                "data[FireExtinguisher][fire_extinguisher_type_id]": {
                    greaterThanZero: true,
                },
            }
        });
        $('#FireExtinguisherFireExtinguisherTypeId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="fireExtinguishers_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="fireExtinguishers form col-md-8">
            <h4><?php echo __('Add Fire Extinguisher'); ?></h4>
            <?php echo $this->Form->create('FireExtinguisher', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('name', array('label' => __('Name'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('fire_extinguisher_type_id', array('style' => 'width:100%', 'label' => __('Fire Extinguisher Type'))); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('description', array('label' => __('Description'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('company_name', array('label' => __('Company Name'))); ?></div>
                <div class="col-md-3"><?php echo $this->Form->input('purchase_date', array('label' => __('Purchase Date'))); ?></div>
                <div class="col-md-3"><?php echo $this->Form->input('expeiry_date', array('label' => __('Expiry Date'))); ?></div>
                <div class="col-md-3"><?php echo $this->Form->input('warrenty_expiry_date', array('label' => __('Warranty Expiry Date'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('model_type', array('label' => __('Model Type'))); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('other_remarks', array('label' => __('Other Remarks'))); ?></div>
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
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#fireExtinguishers_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>
<script>
    $("[name*='purchase_date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
    $("[name*='purchase_date']").datetimepicker('option', 'maxDate', 0);

    $("[name*='expeiry_date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
    $("[name*='expeiry_date']").datetimepicker('option', 'minDate', 0);

    $("[name*='warrenty_expiry_date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
    $("[name*='warrenty_expiry_date']").datetimepicker('option', 'minDate', 0);
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