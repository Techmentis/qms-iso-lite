<?php $i = 1; ?>
<?php if (!isset($materialQualityChecks) || empty($materialQualityChecks)) { ?>
    <div id="material_QC_ajax<?php echo $i; ?>">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading" id="panel<?php echo $i; ?>"><?php echo __('Step') . ' - ' . ($i); ?> <span class="alert-danger glyphicon glyphicon-remove danger pull-right" style="font-size:20px;background:none"type="button" onclick='removeMaterialQualityCheckDiv(<?php echo $i; ?>)'></span></div>
                <div class="panel-body">
                    <fieldset>
                        <div class="col-md-12"><?php echo $this->Form->input('MaterialQC.' . $i . '.name', array('label' => 'Name', 'placeholder' => 'Verify Document Accuracy & Completness.')); ?></div>
                        <div class="col-md-12"><?php echo $this->Form->input('MaterialQC.' . $i . '.details', array('label' => 'Details', 'type' => 'textarea', 'placeholder' => 'Document accuracy & completness must be verified after initial material inspection')); ?></div>
                        <div class="col-md-3"><?php echo $this->Form->input('MaterialQC.' . $i . '.active_status', array('label' => 'Active', 'type' => 'checkbox', 'checked' => true)); ?></div>
                        
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <?php $i++; $j++; ?>
    <div class="col-md-6"><?php echo $this->Form->input('MaterialQualityCheckQualityCheckNumber', array('type' => 'hidden', 'value' => $i)); ?></div>

    <?php echo $this->Js->writeBuffer(); ?>

<?php } else { ?>

    <div id="material_QC_ajax">
        <?php foreach ($materialQualityChecks as $materialQualityCheck) { ?>
            <div id ="material_QC_ajax<?php echo $i; ?>">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading" id="panel<?php echo $i; ?>"><?php echo __('Step') . ' - ' . ($i); ?><span class="alert-danger glyphicon glyphicon-remove danger pull-right" style="font-size:20px;background:none"type="button" onclick='removeMaterialQualityCheckDiv(<?php echo $i; ?>)'></span></div>
                        <div class="panel-body">
                            <fieldset>

                                <div class="col-md-12"><?php echo $this->Form->input('MaterialQC.' . $i . '.name', array('label' => 'Name', 'value' => $materialQualityCheck['MaterialQualityCheck']['name'])); ?></div>
                                <div class="col-md-12"><?php echo $this->Form->input('MaterialQC.' . $i . '.details', array('label' => 'Details', 'type' => 'textarea', 'value' => $materialQualityCheck['MaterialQualityCheck']['details'])); ?></div>
                                <div class="col-md-3"><?php echo $this->Form->input('MaterialQC.' . $i . '.active_status', array('label' => 'Active', 'type' => 'checkbox', 'checked' => true)); ?></div>
                                 <div class="col-md-3"><?php echo $this->Form->input('MaterialQC.' . $i . '.material_quality_check_id', array('type' => 'hidden', 'value' => $materialQualityCheck['MaterialQualityCheck']['id'])); ?></div>
                               
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <?php $i++; } ?>
    </div>
    <div class="col-md-6"><?php echo $this->Form->input('MaterialQualityCheckQualityCheckNumber', array('type' => 'hidden', 'value' => $i)); ?></div>
<?php } ?>