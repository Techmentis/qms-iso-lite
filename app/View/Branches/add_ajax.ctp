<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_ajax",
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
        $('#BranchAddAjaxForm').validate();
        $('#BranchName').blur(function() {
            $("#getBranch").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_branch_name/' + encodeURIComponent(this.value), function(response, status, xhr) {
                if (response != "") {
                    $('#BranchName').val('');
                    $('#BranchName').addClass('error');
                } else {
                    $('#BranchName').removeClass('error');
                }
            });
        });
    });
</script>

<div id="branches_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="branches form col-md-8">
            <h4><?php echo __("Add Branch"); ?></h4>
            <?php echo $this->Form->create('Branch', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('name', array('label' => __('Branch Name'))); ?>
                    <label id="getBranch" class="error" style="clear:both" ></label>
                </div>
                <?php
                    echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id')));
                    echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id')));
                    echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id']));
                ?>
            </div>
            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#branches_ajax', 'async' => 'false','id'=>'submit_id')); ?>
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
        }});
</script>