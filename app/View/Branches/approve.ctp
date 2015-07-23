<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $().ready(function() {
        $("#submit-indicator").hide();
        $('#BranchApproveForm').validate();
        $("#submit_id").click(function(){
             if($('#BranchApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $('#BranchApproveForm').submit();
             }});
        $('#BranchName').blur(function() {
            $("#getBranch").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_branch_name/' + encodeURIComponent(this.value) + '/<?php echo $this->data['Branch']['id']; ?>', function(response, status, xhr) {
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
    <div class="nav panel panel-default">
        <div class="branches form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Branch'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('Branch', array('role' => 'form', 'class' => 'form')); ?>

            <fieldset>
                <?php echo $this->Form->input('id'); ?>
                <div class="row">
                    <div class="col-md-12"><?php echo $this->Form->input('name', array('label' => __('Branch Name'))); ?>
                        <label id="getBranch" class="error" style="clear:both" ></label>
                    </div>
                </div>
                <?php
                    if ($showApprovals && $showApprovals['show_panel'] == true) {
                        echo $this->element('approval_form');
                    } else {
                        echo $this->Form->input('publish', array('label' => __('Publish')));
                    }
                ?>
                <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
                 <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
                <?php echo $this->Form->end(); ?>
                <?php echo $this->Js->writeBuffer(); ?>
            </fieldset>

        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#branches_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>