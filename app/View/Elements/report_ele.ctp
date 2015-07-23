<div class="reports form col-md-8">
    <h4>Add Report <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info'));
?>	    <?php echo $this->Html->link('', '#advanced_search', array('class' => 'glyphicon glyphicon-search h4-title', 'data-toggle' => 'modal')); ?>
        <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
    </h4>
    <?php echo $this->Form->create('Report', array('controller' => 'reports', 'action' => 'add'), array('role' => 'form', 'class' => 'form'));
    ?>	<fieldset>
        <div class="panel panel-default">
            <div class="panel-body">
                Below is the system generated report. You can modify this report and save it under report center. <br/>
                Report is rendered in a Text Editor so that you can make the required changes.<br/>
                You can either publish this report as it is or keep it ready in reports center.
            </div>
        </div>
        <textarea id="ReportDetails" name="data[Report][details]" style="float:left; clear:both">
            <?php echo $drawRecords ?>
        </textarea>
        <div class="row">
            <div class="col-md-12"><?php echo $this->Form->input('title'); ?></div>
            <div class="col-md-12"><?php echo $this->Form->input('description'); ?></div>
            <div class="col-md-4"><?php echo $this->Form->input('branch_id', array('style' => 'width:100%', 'options' => $PublishedBranchList)); ?></div>
            <div class="col-md-4"><?php echo $this->Form->input('department_id', array('style' => 'width:100%', 'options' => $PublishedDepartmentList)); ?></div>
            <div class="col-md-4"><?php echo $this->Form->input('report_date'); ?></div>
            <div class="col-md-6"><?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $masterListOfFormatId, 'style' => 'width:100%')); ?></div>
            <?php echo $this->Form->input('publish', array('label' => __('Publish'))); ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success')); ?>
        </div>
        <?php echo $this->Form->end(); ?>
        <?php echo $this->Js->writeBuffer(); ?>
    </fieldset>
    <?php echo $masterListOfFormatId ?>
</div>
<script>
    $("#ReportReportDate").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
    });
</script>
<div class="col-md-4">
    <p><?php echo $this->element('helps'); ?></p>
</div>
<?php echo $this->Html->script(array('ckeditor/ckeditor')); ?>
<script type="text/javascript">
    CKEDITOR.replace('ReportDetails', {toolbar: [
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