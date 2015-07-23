<div id="material_QC_ajax<?php echo $i; ?>">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo __('Step') . ' - ' . ($i + 1); ?> <span class="alert-danger glyphicon glyphicon-remove danger pull-right" style="font-size:20px;background:none"type="button" onclick='removeMaterialQualityCheckDiv(<?php echo $i; ?>)'></span></div>
            <div class="panel-body">
                <fieldset>
                    <div class="col-md-12"><?php echo $this->Form->input('MaterialQualityCheck.' . $i . '.name', array('label' => 'Name', 'placeholder' => 'Verify Document Accuracy & Completness.')); ?></div>
                    <div class="col-md-12"><?php echo $this->Form->input('MaterialQualityCheck.' . $i . '.details', array('label' => 'Details', 'type' => 'textarea', 'placeholder' => 'Document accuracy & completness must be verified after initial material inspection')); ?></div>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<?php $i++; $j++; ?>
<?php echo $this->Js->writeBuffer(); ?>