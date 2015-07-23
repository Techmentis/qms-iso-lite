<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
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
                }
            });
        }
    });

    $().ready(function() {
        $("#submit-indicator").hide();
        $('#MaterialAddAjaxForm').validate();
        $('#MaterialName').blur(function() {
            $("#getMaterial").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_material_name/' + encodeURIComponent(this.value), function(response, status, xhr) {
                if (response != "") {
                    $('#MaterialName').val('');
                    $('#MaterialName').addClass('error');
                } else {
                    $('#MaterialName').removeClass('error');
                }
            });
        });
    });
</script>

<div id="materials_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="materials form col-md-8">
            <h4><?php echo __('Add Material'); ?></h4>
            <?php echo $this->Form->create('Material', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
            <div class="row">
                <div class="col-md-12">
                    <?php echo $this->Form->input('name'); ?>
                    <label id="getMaterial" class="error" style="clear:both" ></label>
                </div>
                <div class="col-md-12"><?php echo $this->Form->input('description'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?></div>
            </div>
            <div class="clearfix"><br /></div>
            <div class="panel panel-default">
                <div class="panel-heading"><div class="panel-title"><h5><?php echo __('Add to List of materials with shelf life?'); ?> <small><?php echo __('Data added below will be saved to "Material List with Shelf Life" table.'); ?></small></h5></div></div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('MaterialListWithShelfLife.shelflife_by_manufacturer'); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('MaterialListWithShelfLife.shelflife_by_company'); ?></div>
                        <div class="col-md-12"><?php echo $this->Form->input('MaterialListWithShelfLife.remarks'); ?></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12"><br /></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        <h5><?php echo __('Quality Check Required?'); ?></h5>
                        <span><?php echo $this->Form->input('qc_required', array('div' => array('style' => array('padding-left:0')), 'legend' => false, 'type' => 'radio', 'options' => array(1 => 'Yes', 0 => 'No'), 'default' => 0)); ?></span>
                    </div>
                </div>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish');
                }
            ?>
            <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#materials_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>

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