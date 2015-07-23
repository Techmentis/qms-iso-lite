<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>
<script>
    $().ready(function () {
        $('#InternalAuditPlanApproveForm').validate();
        $("#submit-indicator").hide();
    $("#submit_id").click(function(){
             if($('#InternalAuditPlanApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#InternalAuditPlanApproveForm").submit();
             }

        });
    });
</script>
<div id="internalAuditPlans_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="internalAuditPlans form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Internal Audit Plan'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>

<script>
    $(function() {
        $("#subtabs").tabs();
    });
</script>
            <?php echo $this->Form->create('InternalAuditPlan', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('title'); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('schedule_date_from'); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('schedule_date_to'); ?></div>
                <div class="col-md-12">  <label for="InternalAuditPlanNote">Note</label></div>
                <div class="col-md-12" style='clear:both'>
                    <textarea name="data[InternalAuditPlan][note]" id="InternalAuditPlanNote"  style="">
                        <?php echo $this->data[InternalAuditPlan][note]; ?>
                    </textarea>
                </div>
                <?php echo $this->Form->input('show_on_timeline', array('type' => 'hidden')); ?>
                <?php echo $this->Form->input('notify_users', array('type' => 'hidden')); ?>
                <?php echo $this->Form->input('notify_users_emails', array('type' => 'hidden')); ?>
            </div>

            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#internalAuditPlans_ajax', 'async' => 'false','id'=>'submit_id')); ?>
                    <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>

<script>
    var startDateTextBox = $('#InternalAuditPlanScheduleDateFrom');
    var endDateTextBox = $('#InternalAuditPlanScheduleDateTo');

    startDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        onClose: function (dateText, inst) {
            if (endDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    endDateTextBox.val(startDateTextBox.val());
            } else {
                endDateTextBox.val(dateText);
            }
        },
        onSelect: function (selectedDateTime) {
            endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate'));
        }
    }).attr('readonly', 'readonly');
    endDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        onClose: function (dateText, inst) {
            if (startDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker(' getDate');
                if (testStartDate > testEndDate)
                    startDateTextBox.val(endDateTextBox.val());
            } else {
                startDateTextBox.val(dateText);
            }
        },
        onSelect: function (selectedDateTime) {
            startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate'));
        }
    }).attr('readonly', 'readonly');
</script>

        <?php echo $this->Html->script(array('ckeditor/ckeditor')); ?>
        <?php echo $this->fetch('script'); ?>

<script type="text/javascript">
    CKEDITOR.replace('InternalAuditPlanNote', {toolbar: [
            ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
            {name: 'insert', items: ['Table', 'HorizontalRule', 'SpecialChar', 'PageBreak']},
            {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
            {name: 'document', items: ['Preview', '-', 'Templates']},
            '/',
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']},
            {name: 'basicstyles', items: ['Bold', 'Italic']},
            {name: 'styles', items: ['Format', 'FontSize']},
            {name: 'colors', items: ['TextColor', 'BGColor']},
        ]
    });
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#internalAuditPlans_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

