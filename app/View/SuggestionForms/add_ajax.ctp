<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[SuggestionForm][employee_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
        submitHandler: function (form) {
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
                error: function (request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
            });
        }
    });

    $().ready(function () {
        $("#submit-indicator").hide();
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#SuggestionFormAddAjaxForm').validate({
            rules: {
                "data[SuggestionForm][employee_id]": {
                    greaterThanZero: true,
                },
            }
        });
        $('#SuggestionFormEmployeeId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="suggestionForms_ajax">
    <?php echo $this->Session->flash(); ?><div class="nav">
        <div class="suggestionForms form col-md-8">
            <h4><?php echo __('Add New Suggestion'); ?></h4>
            <?php echo $this->Form->create('SuggestionForm', array('role' => 'form', 'class' => 'form')); ?>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('employee_id'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('title'); ?></div>
            </div>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('activity'); ?></div>
            </div>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('suggestion'); ?></div>
            </div>
            <div class="row">
                <?php if (!($this->Session->read('User.is_mr') == 0 or $this->Session->read('User.is_mr') == false )) { ?>
                    <div class="col-md-12"><?php echo $this->Form->input('remark'); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><h6>Add To CAPA ?</h6><?php echo $this->Form->input('add_to_capa', array('type' => 'radio', 'legend' => false, 'options' => array('Yes', 'No'))); ?></div>
                <?php } ?>
                <?php
                    echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id')));
                    echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id')));
                    echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id']));
                ?>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#orderRegisters_ajax', 'async' => 'false','id'=>'submit_id')); ?>
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

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>