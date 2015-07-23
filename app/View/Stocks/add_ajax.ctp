<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<?php if ($this->request->params['pass'][0] == 0) { ?>

<script>
$.validator.setDefaults({
    ignore: null,
    errorPlacement: function(error, element) {
        if(
           $(element).attr('name') == 'data[Stock][production_id]' ||
           $(element).attr('name') == 'data[Stock][material_id]'){
             $(element).next().after(error);
        }else{
               $(element).after(error);
        }
    },
    submitHandler: function(form) {
        var prodID = $('[name="data[Stock][production_id]"]').val();
        var matID = $('[name="data[Stock][material_id]"]').val();
        var prodDate = $('#StockProductionDate').val();
        $.get('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/checkProdMatDate/' + prodID + '/' + matID + '/' + prodDate, function(data,status){

            if(!data){
                $(form).ajaxSubmit({
                    url:'<?php echo Router::url('/', true);?><?php echo $this->request->params['controller']?>/add_ajax',
                    type:'POST',
                    target: '#main',
                    beforeSend: function(){
                        $("#submit_id").prop("disabled",true);
                        $("#submit-indicator").show();
                    },
                    complete: function() {
                       $("#submit_id").removeAttr("disabled");
                       $("#submit-indicator").hide();
                    },
                    error: function (request, status, error) {
                        //alert(request.responseText);
                        alert('Action failed!');
                    }
                });
            } else{
                $('#materialProdDateExists').append('<label class="error">Batch with same Material and Production date, already exists. You can edit it <a href="<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller']; ?>/edit/'+data+'"><strong>HERE</strong></a></label>');
            }
        });
    }
});

$().ready(function() {
    $("#submit-indicator").hide();
    jQuery.validator.addMethod("greaterThanZero", function(value, element) {
        return this.optional(element) || (parseFloat(value) > 0);
    }, "Please select the value");

    jQuery.validator.addMethod("greaterQtyConsumed", function (value, element) {
        var qtyConsumed = $('[name="data[Stock][quantity_consumed]"]').val();
        var qtyInHand = $('[name="data[quantity_in_hand]"]').val();
        return Number(qtyConsumed) > Number(qtyInHand) ? false : true;
    }, "Quantity consumed is higher than \'Quantity in hand\'");

    $('#StockAddAjaxForm').validate({
        rules: {
            "data[Stock][production_id]" : {
                greaterThanZero:true
            },
            "data[Stock][material_id]" : {
                greaterThanZero:true
            },
            "data[Stock][production_date]" : {
                required:true
            },
            "data[Stock][quantity_consumed]" : {
                required:true,
                greaterQtyConsumed: true
            }
        }
    });
    $('#StockProductionId').change(function () {
        if( $( this ).val()!=-1 && $(this).next().next('label').hasClass("error")){
            $(this).next().next('label').remove();
        }
    });
    $('#StockMaterialId').change(function () {
        if( $( this ).val()!=-1 && $(this).next().next('label').hasClass("error")){
            $(this).next().next('label').remove();
        }
    });
});
</script>

<?php } elseif ($this->request->params['pass'][0] == 1) { ?>

<script>
$.validator.setDefaults({
    ignore: null,
    errorPlacement: function(error, element) {
        if(
           $(element).attr('name') == 'data[Stock][delivery_challan_id]' ||
           $(element).attr('name') == 'data[Stock][material_id]' ||
           $(element).attr('name') == 'data[Stock][branch_id]'){
            $(element).next().after(error);
        }else{
    	   $(element).after(error);
        }
    },
    submitHandler: function(form) {
        $(form).ajaxSubmit({
            url: '<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_ajax',
            type: 'POST',
            target: '#main',
            beforeSend: function(){
               $("#submit_id").prop("disabled",true);
                $("#submit-indicator").show();
            },
            complete: function() {
               $("#submit_id").removeAttr("disabled");
               $("#submit-indicator").hide();
            },
            error: function(request, status, error) {
                //alert(request.responseText);
		alert('Action failed!');
            }
        });
    }
});

$().ready(function() {
    $("#submit-indicator").hide();
    jQuery.validator.addMethod("greaterThanZero", function(value, element) {
        return this.optional(element) || (parseFloat(value) > 0);
    }, "Please select the value");

    $('#StockAddAjaxForm').validate({
        rules: {
            "data[Stock][delivery_challan_id]" : {
                greaterThanZero:true,
            },
            "data[Stock][material_id]" : {
                greaterThanZero:true,
            },
            "data[Stock][branch_id]" : {
                greaterThanZero:true,
            },
            "data[Stock][received_date]": {
                required: true,
            }
        }
    });
    $('#StockDeliveryChallanId').change(function() {
        if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
            $(this).next().next('label').remove();
        }
    });
    $('#StockMaterialId').change(function() {
        if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
            $(this).next().next('label').remove();
        }
    });
    $('#StockBranchId').change(function() {
        if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
            $(this).next().next('label').remove();
        }
    });
});
</script>

<?php } ?>

<script>
	$(document).ready(function(){
		$('#StockProductionId').change(function(){$('#material').load('<?php echo Router::url('/', true);?><?php echo $this->request->params['controller']?>/get_material/'+$('#StockProductionId').val())});
	});
</script>

<div id="stocks_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="stocks form col-md-8">
            <h4><?php echo __('Add Stock'); ?></h4>
            <?php echo $this->Form->create('Stock', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <?php if ($this->request->params['pass'][0] == 0) { ?>

                <div class="row">
                    <div class="hide"><?php echo $this->Form->hidden('type', array('value' => $this->request->params['pass'][0])); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('production_id', array('label' => __('Select Batch'))); ?></div>
                    <div class="col-md-6" id="material"></div>
                    <div class="col-md-12"></div>
                    <div class="col-md-12" id="materialDetails"></div>
                    <div class="col-md-4"><?php echo $this->Form->input('production_date'); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('quantity_consumed'); ?></div>
                    <div class="col-md-12"><?php echo $this->Form->input('remarks'); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?></div>
                    <?php echo $this->Form->hidden('quantity', array('value' => 0)); ?>
                </div>

            <?php } else if ($this->request->params['pass'][0] == 1) { ?>

<script>
    $('document').ready(function(){
            $('#StockDeliveryChallanId').change(function(){
                    $('#details').load('<?php echo Router::url('/', true);?><?php echo $this->request->params['controller']?>/get_dc_details/' + $('#StockDeliveryChallanId').val());
            })
    });
</script>

                <div class="row">
                    <div class="hide"><?php echo $this->Form->hidden('type', array('value' => $this->request->params['pass'][0])); ?></div>
                    <div class="col-md-12"><?php echo $this->Form->input('delivery_challan_id'); ?></div>
                    <div id="details">
                    </div>
                    <div class="col-md-6"><?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?></div>
                </div>

            <?php } else { ?>
                <div class="row"><div class="col-md-12"><?php echo __('Invalid Selection'); ?></div></div>
            <?php } ?>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish');
                }
            ?>

            <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#stocks_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <div id="materialProdDateExists"></div>
            <div class="clearfix">&nbsp;</div>

            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>

<script>
    $("[name*='date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>