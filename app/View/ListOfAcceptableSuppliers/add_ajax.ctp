<div class="row">
	<div class="col-md-4">
		<div class="panel-body">
		<h2><?php echo __('As per the process, List of acceptable suppliers can only be added after due evaluations.'); ?></h2>
		<p><?php
         echo __('Please go to MR dashboad and click on Evaluate button under "Supplier Evaluation / Re-Evaluation" panel.') . '<br />' .
         __('Then select the supplier you wish to evaluate from the drop down.') . '<br />' .
			      __('Based of the Delivery Challans and Purchase Order History, system will provide ou with basic analytics for the supplier.') . '<br />' .
         __('You then the evaluate the suppler and add supplier to the list form the same page.');
  ?></p>
		</div>
	</div>
	<div class="col-md-8">
		<p>
		<h3 style="margin-left: 20px;"><?php echo __('Typical Supplier Evaluation Process'); ?></h3>
			<?php echo $this->Html->image('help-images/process-flows/supplier-evaluations.png'); ?>
		</p>
		</div>
</div>

<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min'));?>
<?php echo $this->fetch('script');?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if($(element).attr('name') == 'data[ListOfAcceptableSupplier][supplier_registration_id]' ||
               $(element).attr('name') == 'data[ListOfAcceptableSupplier][supplier_category_id]'){
                 $(element).next().after(error);
            }else{
                   $(element).after(error);
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url:"<?php echo Router::url('/', true);?><?php echo $this->request->params['controller']?>/add_ajax",
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
        }
    });

    $().ready(function() {
        $("#submit-indicator").hide();
        jQuery.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#ListOfAcceptableSupplierAddAjaxForm').validate({
            rules: {
                "data[ListOfAcceptableSupplier][supplier_registration_id]" : {
                    greaterThanZero:true,
                },
                "data[ListOfAcceptableSupplier][supplier_category_id]" : {
                    greaterThanZero:true,
                },
            }
        });
        $('#ListOfAcceptableSupplierSupplierRegistrationId').change(function () {
            if( $( this ).val()!=-1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();}});
        $('#ListOfAcceptableSupplierSupplierCategoryId').change(function () {
            if( $( this ).val()!=-1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();}});
    });
</script>

<div id="listOfAcceptableSuppliers_ajax" style="display: none">
    <?php echo $this->Session->flash(); ?><div class="nav">
        <div class="listOfAcceptableSuppliers form col-md-8">
            <h4><?php echo __('Add Acceptable Supplier'); ?></h4>
            <?php echo $this->Form->create('ListOfAcceptableSupplier', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('supplier_registration_id', array('style' => 'width:100%', 'label' => __('Supplier'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('supplier_category_id', array('style' => 'width:100%', 'label' => __('Supplier Category'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('remarks', array('label' => __('Remarks'))); ?></div>
                <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#listOfAcceptableSuppliers_ajax', 'async' => 'false', 'id' => 'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>

        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>