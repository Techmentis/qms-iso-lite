<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>
<div id="users_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="row panel panel-default">
        <div class="col-md-12">
            <?php echo $this->Form->create('User', array('role' => 'form', 'class' => 'form')); ?>
            <table class="table table-responsive" >

                <?php
                    $i = 0;
                    foreach ($allFormats as $key => $value):
                        $j = 1;
                ?>
                    <tr><th colspan="4"><h4><?php echo $key ?></h4></th></tr>
                    <tr>
                        <th width="1%">#</th>
                        <th width="39%">Title</th>
                        <th width="15%">Prepared By</th>                        
                        <th width="15%">Approved By</th>                        
                        <th width="10%">Document No</th>
                        <th width="5%">Issue No</th>
                        <th width="6%">Rev No</th>
                        <th width="9%">Rev Date</th>
                    </tr>
                    <?php foreach ($value as $masterlist): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $this->Form->input($i . '.MasterListOfFormat.title', array('label' => false, 'value' => $masterlist['MasterListOfFormat']['title'])); ?></td>
                            <td><?php echo $this->Form->input($i . '.MasterListOfFormat.prepared_by', array('label' => false, 'options' => $PublishedEmployeeList,'value' => $this->Session->read('User.employee_id'))); ?></td>
                            <td><?php echo $this->Form->input($i . '.MasterListOfFormat.approved_by', array('label' => false, 'options' => $PublishedEmployeeList,'value' => $this->Session->read('User.employee_id'))); ?></td>                            
                            <td><?php echo $this->Form->input($i . '.MasterListOfFormat.document_number', array('label' => false, 'value' => substr(strtoupper($companyDetails['Company']['name']), 0, 2) . substr(strtoupper($key), 0, 2) . str_pad($j, 4, 0, STR_PAD_LEFT))); ?></td>
                            <td><?php echo $this->Form->input($i . '.MasterListOfFormat.issue_number', array('label' => false, 'value' => str_pad(1, 2, 0, STR_PAD_LEFT))); ?></td>
                            <td><?php echo $this->Form->input($i . '.MasterListOfFormat.revision_number', array('label' => false, 'value' => str_pad(1, 2, 0, STR_PAD_LEFT))); ?></td>
                            <td><?php echo $this->Form->input($i . '.MasterListOfFormat.revision_date', array('label' => false, 'value' => date(strtotime('Y-m-d')))); ?></td>


                            <?php echo $this->Form->hidden($i . '.MasterListOfFormat.prepared_by', array('label' => false, 'value' => $this->Session->read('User.employee_id'))); ?>
                            <?php echo $this->Form->hidden($i . '.MasterListOfFormat.approved_by', array('label' => false, 'value' => $this->Session->read('User.employee_id'))); ?>
                            <?php echo $this->Form->hidden($i . '.MasterListOfFormat.company_id', array('label' => false, 'value' => $this->Session->read('User.company_id'))); ?>
                            <?php echo $this->Form->hidden($i . '.MasterListOfFormat.system_table_id', array('type' => 'text', 'label' => false, 'value' => $masterlist['MasterListOfFormat']['system_table_id'])); ?>
                            <?php echo $this->Form->hidden($i . '.MasterListOfFormatDepartment.department_id', array('type' => 'text', 'label' => false, 'value' => $masterlist['MasterListOfFormatDepartment']['department_id'])); ?>
                            <?php echo $this->Form->hidden($i . '.MasterListOfFormatBranch.branch_id', array('type' => 'text', 'label' => false, 'value' => $this->Session->read('User.branch_id'))); ?>                            
                        </tr>

                        <?php $i++; $j++;
                    endforeach;
                endforeach;
                ?>
            </table>
            <?php echo $this->Form->submit(__('Go to Dashboard'), array('div' => false, 'class' => 'btn btn-primary btn-success btn-lg' ,'id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        <script>
            $("[name*='date']").val('<?php echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>');
            $("[name*='date']").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
            });</script>
    </div>
</div>

<script>
    $("#submit-indicator").hide();
    $("#submit_id").click(function(){

             $("#submit_id").prop("disabled",true);
             $("#submit-indicator").show();
             $("#UserAddFormatsForm").submit();

    });
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>