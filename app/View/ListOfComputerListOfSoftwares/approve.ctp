<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[ListOfComputerListOfSoftware][list_of_computer_id]' ||
                    $(element).attr('name') == 'data[ListOfComputerListOfSoftware][list_of_software_id]') {
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

        $('#ListOfComputerListOfSoftwareApproveForm').validate({
            rules: {
                "data[ListOfComputerListOfSoftware][list_of_computer_id]": {
                    greaterThanZero: true,
                },
                "data[ListOfComputerListOfSoftware][list_of_software_id]": {
                    greaterThanZero: true,
                },
            }
        });
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#ListOfComputerListOfSoftwareApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#ListOfComputerListOfSoftwareApproveForm").submit();
             }

        });
        $('#ListOfComputerListOfSoftwareListOfComputerId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#ListOfComputerListOfSoftwareListOfSoftwareId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });

    });
</script>

<div id="listOfComputerListOfSoftwares_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="listOfComputerListOfSoftwares form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Computer Software'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('ListOfComputerListOfSoftware', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-4"><?php echo $this->Form->input('list_of_computer_id', array('style' => 'width:100%', 'label' => __('Computer Name'))); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('list_of_software_id', array('style' => 'width:100%', 'label' => __('Software Name'))); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('installation_date'); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('other_details'); ?></div>
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
        </div>

<script>
    $("[name*='installation_date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
    $("[name*='installation_date']").datetimepicker();
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>

    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#listOfComputerListOfSoftwares_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>

</div>
