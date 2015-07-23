<div id="dataTypes_ajax">
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
    <?php echo $this->fetch('script'); ?>

    <script>
        $.validator.setDefaults({
            ignore: null,
            errorPlacement: function(error, element) {
                if ($(element).attr('name') == 'data[DataType][user_id]')
                    $(element).next().after(error);
                else {
                    $(element).after(error);
                }
            },
        });

        $().ready(function() {

            jQuery.validator.addMethod("greaterThanZero", function(value, element) {
                return this.optional(element) || (parseFloat(value) > 0);
            }, "Please select the value");

            $('#DataTypeApproveForm').validate({
                rules: {
                    "data[DataType][user_id]": {
                        greaterThanZero: true,
                    },
                }
            });
            $("#submit-indicator").hide();
            $("#submit_id").click(function(){
             if($('#DataTypeApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#DataTypeApproveForm").submit();
             }

        });
            $('#DataTypeUserId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
        });
    </script>

    <div class="nav panel panel-default">
        <div class="dataTypes form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Data Type'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('DataType', array('role' => 'form', 'class' => 'form')); ?>

            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('name'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('user_id', array('style' => 'width:90%')); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('details'); ?></div>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator'));?>
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
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#dataTypes_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>