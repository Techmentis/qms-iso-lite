<div id="softwareLists_ajax<?php echo $i; ?>">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo __('Software'); ?><span class="alert-danger glyphicon glyphicon-remove danger pull-right" style="font-size:20px;background:none"type="button" onclick='removeAgendaDiv(<?php echo $i; ?>)'></span></div>
            <div class="panel-body">
                <fieldset>
                    <div class="col-md-6"><?php echo $this->Form->input('ListOfComputerListOfSoftware.' . $i . '.list_of_software_id', array('label' => __('Software Name'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('ListOfComputerListOfSoftware.' . $i . '.installation_date'); ?></div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<?php
    $i++;
    $j++;
?>

<script>
    $("[name*='date']").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });
    $(".chosen-select").chosen();
</script>

<?php echo $this->Js->writeBuffer(); ?>