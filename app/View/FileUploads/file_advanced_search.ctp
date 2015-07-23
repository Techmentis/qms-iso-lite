<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min'));?>
<?php echo $this->fetch('script');?>
<script>
    $().ready(function() {
        $("#submit-indicator").hide();
	$("#submit_id").click(function(){
	    $("#submit_id").prop("disabled",true);
	    $("#submit-indicator").show();
	    $("#capa_advanced-search-form").submit();
        });
    });
</script>
<?php
    $postData = null;
    $postData = array('file_details' => 'Name','version' => 'Version','file_type'=>'File Type','comment'=>'Comment');
?>

    <div class="nav panel panel-default">
        <div class="file_search form col-md-8">
            <h4><?php echo __("Search Documents"); ?></h4>
                <?php echo $this->Form->create($this->name, array('action' => 'file_advanced_search', 'role' => 'form', 'class' => 'advanced-search-form', 'id' => 'fileupload_advanced-search-form', 'type' => 'get')); ?>
                <div class="row">
                    <div class="col-md-12"><?php echo $this->Form->input('Search.keywords', array('label' => __('Type Keyword & select the field which you want to search from below'))); ?></div>
                    <br />
                    <div class="col-md-12"><?php echo $this->Form->input('Search.search_fields', array('label' => false, 'options' => array($postData), 'multiple' => 'checkbox', 'class' => 'checkbox-inline col-md-3')); ?></div>
                </div>
            
                <div class="col-md-12"><hr /></div>

                
                <div class="row">
                    <div class="col-md-6"><?php echo $this->Form->input('master_list_of_id', array('label' => __('Select Master List Of Format'), 'options' => $masterListOfFormat, 'multiple' => false, 'class' => 'form-control')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('system_table_id', array('label' => __('Select Table you want to search'), 'options' => $system_table, 'multiple' => false, 'class' => 'form-control')); ?></div>
                </div>
                
                <div class ="row">
                    <div class = "col-md-6"><?php echo $this->Form->input('prepared_by', array('options' => $PublishedEmployeeList, 'style'=>array('width'=>'100%'))); ?></div>
                    <div class = "col-md-6"><?php echo $this->Form->input('approved_by', array('options' => $PublishedEmployeeList)); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('Search.branch_list', array('label' => __('Select branches you want to search'), 'options' => $PublishedBranchList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                </div>
                
               <div class="row">
                    <div class="col-md-12"><hr /></div>
                    <div class="col-md-4"><?php echo $this->Form->input('Search.from-date', array('id' => 'ddfrom', 'label' => __('Select start date'))); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('Search.to-date', array('id' => 'ddto', 'label' => __('Select end date'))); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('Search.strict_search', array('label' => __('Strict Search'), 'options' => array('Yes', 'No'), 'checked' => 1, 'type' => 'radio')); ?></div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
			<?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#capa_main_inner', 'async' => 'false', 'id'=>'submit_id')); ?>
			<?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
    </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
</div>
<script>
    function datePicker() {
        $("[name*='date']").datetimepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            'showTimepicker': false,
        }).attr('readonly', 'readonly');
    }
</script>
<script>
    var startDateTextBox = $('#ddfrom');
    var endDateTextBox = $('#ddto');

    startDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
        changeMonth: true,
        changeYear: true,
        beforeShow: function(input, inst) {
            var offset = $(input).offset();
            var height = $(input).height();
            window.setTimeout(function() {
                inst.dpDiv.css({top: (offset.top + height - 260) + 'px'})
            })
        },
        onClose: function(dateText, inst) {
            if (endDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate) {
                    endDateTextBox.val(startDateTextBox.val());
                }
            }
            else {
                endDateTextBox.val(dateText);
            }
        },
        onSelect: function(selectedDateTime) {
            endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate'));
        }
    }).attr('readonly', 'readonly');
    endDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
        changeMonth: true,
        changeYear: true,
        beforeShow: function(input, inst) {
            var offset = $(input).offset();
            var height = $(input).height();
            window.setTimeout(function() {
                inst.dpDiv.css({top: (offset.top + height - 260) + 'px'});
            })
        },
        onClose: function(dateText, inst) {
            if (startDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    startDateTextBox.val(endDateTextBox.val());
            }
            else {
                startDateTextBox.val(dateText);
            }
        },
        onSelect: function(selectedDateTime) {
            startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate'));
        }
    }).attr('readonly', 'readonly');
</script>