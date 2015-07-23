<div id="internetUsageDetails_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="internetUsageDetails form col-md-8">
            <h4><?php echo __('View Internet Usage Detail'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($internetUsageDetail['InternetUsageDetail']['sr_no']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Internet Provider Name'); ?></td>
                    <td>
                        <?php echo h($internetUsageDetail['InternetUsageDetail']['internet_provider_name']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Plan Details'); ?></td>
                    <td>
                        <?php echo h($internetUsageDetail['InternetUsageDetail']['plan_details']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('From Date'); ?></td>
                    <td>
                        <?php echo h($internetUsageDetail['InternetUsageDetail']['from_date']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('To Date'); ?></td>
                    <td>
                        <?php echo h($internetUsageDetail['InternetUsageDetail']['to_date']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Download'); ?></td>
                    <td>
                        <?php echo h($internetUsageDetail['InternetUsageDetail']['download']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($internetUsageDetail['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($internetUsageDetail['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($internetUsageDetail['InternetUsageDetail']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;</td></tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($internetUsageDetail['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $internetUsageDetail['BranchIds']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($internetUsageDetail['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $internetUsageDetail['DepartmentIds']['id'])); ?>
                        &nbsp;
                    </td></tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $internetUsageDetail['InternetUsageDetail']['created_by'], 'recordId' => $internetUsageDetail['InternetUsageDetail']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php echo $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#internetUsageDetails_ajax'))); ?>

    <?php echo $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $internetUsageDetail['InternetUsageDetail']['id'], 'ajax'), array('async' => true, 'update' => '#internetUsageDetails_ajax'))); ?>

    <?php echo $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#internetUsageDetails_ajax'))); ?>

<?php echo $this->Js->writeBuffer(); ?>

</div>
<script>$.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});</script>
