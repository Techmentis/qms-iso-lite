<div id="users_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="users form col-md-8">
            <h4><?php echo __('Add User'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Username : '); ?></td><td><?php echo $this->request->data['User']['username']; ?></td></tr>
                <tr><td><?php echo __('Name : '); ?></td><td><?php echo $this->request->data['User']['name']; ?></td></tr>
            </table>
            <?php echo $this->Form->create('User', array('role' => 'form', 'class' => 'form')); ?>
            <fieldset>
                <?php echo $this->Form->input('Branch.branch_id', array('options' => $PublishedBranchList, 'multiple' => true, 'class' => 'form-control')); ?>
                <?php echo $this->Form->input('Department.department_id', array('options' => $PublishedDepartmentList, 'multiple' => true, 'class' => 'form-control')); ?>
                <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success')); ?>
                <?php echo $this->Form->end(); ?>
                <?php echo $this->Js->writeBuffer(); ?>
            </fieldset>
        </div>

        <div class="col-md-4">
            <fieldset><legend><?php echo __('More...'); ?></legend></fieldset>
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#users_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>