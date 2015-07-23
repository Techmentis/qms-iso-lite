<div id="fileUploads_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="fileUploads form col-md-8">
            <h4><?php echo __('View File Upload'); ?>		<?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php //echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($fileUpload['FileUpload']['sr_no']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Record'); ?></td>
                    <td>
                        <?php echo h($fileUpload['FileUpload']['record']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('File Details'); ?></td>
                    <td>
                        <?php echo h($fileUpload['FileUpload']['file_details']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('User'); ?></td>
                    <td>
                        <?php echo $this->Html->link($fileUpload['User']['name'], array('controller' => 'users', 'action' => 'view', $fileUpload['User']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('File Type'); ?></td>
                    <td>
                        <?php echo h($fileUpload['FileUpload']['file_type']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('File Status'); ?></td>
                    <td>
                        <?php echo h($fileUpload['FileUpload']['file_status']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Result'); ?></td>
                    <td>
                        <?php echo h($fileUpload['FileUpload']['result']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('User Session'); ?></td>
                    <td>
                        <?php echo $this->Html->link($fileUpload['UserSession']['id'], array('controller' => 'user_sessions', 'action' => 'view', $fileUpload['UserSession']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($fileUpload['FileUpload']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;</td></tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($fileUpload['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $fileUpload['BranchIds']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($fileUpload['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $fileUpload['DepartmentIds']['id'])); ?>
                        &nbsp;
                    </td></tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $fileUpload['FileUpload']['created_by'], 'recordId' => $fileUpload['FileUpload']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php echo $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#fileUploads_ajax'))); ?>

    <?php echo $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $fileUpload['FileUpload']['id'], 'ajax'), array('async' => true, 'update' => '#fileUploads_ajax'))); ?>

    <?php echo $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#fileUploads_ajax'))); ?>

<?php echo $this->Js->writeBuffer(); ?>

</div>
<script>$.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});</script>
