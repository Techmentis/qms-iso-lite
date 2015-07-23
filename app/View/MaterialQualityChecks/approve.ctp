<script>
    $().ready(function () {
        $('#MaterialQualityCheckApproveForm').validate({
            rules: {
                "data[MaterialQC][0][name]": {
                    required: true
                },
                "data[MaterialQC][0][details]": {
                    required: true
                }
            }
        });
          $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#MaterialQualityCheckApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#MaterialQualityCheckApproveForm").submit();
             }
        });
        $('#MaterialQualityCheckMaterialId').change(function () {
            var a = $(this).val();
 			var i = parseInt($('#MaterialQualityCheckQualityCheckNumber').val());
            $.get("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_material_check/" + $(this).val(), function (data) {
                $('#material_QC_ajax').html(data);
            });
            i = i + 1;
            $('#MaterialQualityCheckNumber').val(i);

        });

    });

    function addMaterialQualityCheckDiv() {
        var i = parseInt($('#MaterialQualityCheckQualityCheckNumber').val());
        $.get("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_process/" + i, function (data) {
            $('#material_QC_ajax').append(data);
        });
        i = i + 1;
        $('#MaterialQualityCheckQualityCheckNumber').val(i);
    }

    function removeMaterialQualityCheckDiv(i) {
            var j = parseInt($('#MaterialQualityCheckQualityCheckNumber').val());
        
        if (j > 2) {
            var r = confirm("Are you sure you want to remove this 'Material Quality Check'?");

            if (r == true) {
                $('#material_QC_ajax' + i).remove();
            for(var k=i+1; k<j;k++){
                var l = k-1;
                $("#material_QC_ajax"+k).attr('id', "material_QC_ajax"+l);
                $("#MaterialQC"+k+"Name").attr('id', "MaterialQC"+l+"Name");
                $("#MaterialQC"+l+"Name").attr('name','data[MaterialQC]['+l+'][name]');
                $("#MaterialQC"+k+"Details").attr('id', "MaterialQC"+l+"Details");
                $("#MaterialQC"+l+"Details").attr('name','data[MaterialQC]['+l+'][details]');
                $("#MaterialQC"+k+"ActiveStatus_").attr('id', "MaterialQC"+l+"ActiveStatus_");
                $("#MaterialQC"+l+"ActiveStatus_").attr('name','data[MaterialQC]['+l+'][active_status]');
                $("#MaterialQC"+k+"ActiveStatus").attr('id', "MaterialQC"+l+"ActiveStatus");
                $("#MaterialQC"+l+"ActiveStatus").attr('name','data[MaterialQC]['+l+'][active_status]');
                
                $("#MaterialQC"+k+"Details").attr('id', "MaterialQC"+l+"Details");
                $("#MaterialQC"+l+"Details").attr('name','data[MaterialQC]['+l+'][details]');
                
                 $("#panel"+k).attr('id',"panel"+l);
                 
                var data = 'Step - '+l+'<span class="alert-danger glyphicon glyphicon-remove danger pull-right" onclick="removeMaterialQualityCheckDiv('+l+')" type="button" style="font-size:20px;background:none"></span>'; 
             
                $("#panel"+l).html(data);
               // $("#panel"+l).attr('html',k); 
                
            }
            $('#MaterialQualityCheckQualityCheckNumber').val(j-1);
        }
        } else {
            $('#mqc_delete_warning').show();
        }
    }
</script>

<div id="materialQualityChecks_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="materialQualityChecks form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Material Quality Check'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('MaterialQualityCheck', array('role' => 'form', 'class' => 'form')); ?>
            <fieldset>

                <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('material_id', array('selected' => $this->request->data['MaterialQualityCheck']['material_id'], 'disabled' => 'disabled')); ?></div>
                    <?php echo $this->Form->hidden('material_used', array('value' => $this->request->data['MaterialQualityCheck']['material_id'])); ?>
                    <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                    <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                </div>

                <div class="clearfix">&nbsp;</div>

                <div id="mqc_delete_warning" class="alert alert-warning alert-dismissible" role="alert" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5>Minimum one 'Material Quality Check' is required, therefore, this quality check can not be deleted!</h5>
                </div>

                <?php $i = 1; ?>

                <div id="material_QC_ajax">
                    <?php foreach ($MaterialQualityChecks as $val) { ?>
                        <div id ="material_QC_ajax<?php echo $i; ?>">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading" id="panel<?php echo $i; ?>">
                                        <?php echo __('Step') . ' - ' . $i; ?>
                                        <?php if(!$val['MaterialQualityCheck']['check_performed']){ ?>
                                            <span class="alert-danger glyphicon glyphicon-remove danger pull-right" style="font-size:20px;background:none" type="button" onclick="removeMaterialQualityCheckDiv(<?php echo $i; ?>)"></span>
                                        <?php } ?>
                                    </div>

                                    <div class="panel-body">
                                        <fieldset>
                                            <div class="col-md-12"><?php echo $this->Form->input('MaterialQC.' . $i . '.name', array('label' => 'Name', 'value' => $val['MaterialQualityCheck']['name'])); ?></div>
                                            <div class="col-md-12"><?php echo $this->Form->input('MaterialQC.' . $i . '.details', array('label' => 'Details', 'type' => 'textarea', 'value' => $val['MaterialQualityCheck']['details'])); ?></div>
                                            <?php
                                                if ($val['MaterialQualityCheck']['active_status']) {
                                                    $checked = true;
                                                } else {
                                                    $checked = false;
                                                }
                                            ?>
                                            <div class="col-md-3"><?php echo $this->Form->input('MaterialQC.' . $i . '.active_status', array('label' => 'Active', 'type' => 'checkbox', 'checked' => $checked)); ?></div>
                                            <?php echo $this->Form->input('MaterialQC.' . $i . '.material_quality_check_id', array('type' => 'hidden', 'value' => $val['MaterialQualityCheck']['id'])); ?>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php $i++; } ?>

                </div>
                <div class="col-md-6"><?php echo $this->Form->input('QualityCheckNumber', array('type' => 'hidden', 'value' => $i)); ?></div>
                <div class="row">
                    <div class="pull-right"><span class="btn btn-info" id="plus" onclick='addMaterialQualityCheckDiv()'>Add Next Step</span></div>
                </div>

                <?php
                    if ($showApprovals && $showApprovals['show_panel'] == true) {
                        echo $this->element('approval_form');
                    } else {
                        echo $this->Form->input('publish');
                    }
                ?>

                <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
                <?php echo $this->Form->end(); ?>
                <?php echo $this->Js->writeBuffer(); ?>
            </fieldset>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
</div>
<?php $this->Js->get('#list'); ?>
<?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#materialQualityChecks_ajax'))); ?>
<?php echo $this->Js->writeBuffer(); ?>
