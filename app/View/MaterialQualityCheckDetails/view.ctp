<div id="materialQualityCheckDetails_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel">
        <div class="materialQualityCheckDetails form col-md-8">
            <h4><?php echo __('View Material Quality Check Detail'); ?>		<?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr No'); ?></td>
                    <td>
                        <?php echo h($materialQualityCheckDetail['MaterialQualityCheckDetail']['sr_no']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Material Quality Check'); ?></td>
                    <td>
                        <?php echo h($materialQualityCheckDetail['MaterialQualityCheck']['name']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($materialQualityCheckDetail['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $materialQualityCheckDetail['Employee']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Check Performed Date'); ?></td>
                    <td>
                        <?php echo h($materialQualityCheckDetail['MaterialQualityCheckDetail']['check_performed_date']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Quantity Received'); ?></td>
                    <td>
                        <?php echo h($materialQualityCheckDetail['MaterialQualityCheckDetail']['quantity_received']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Quantity Accepted'); ?></td>
                    <td>
                        <?php echo h($materialQualityCheckDetail['MaterialQualityCheckDetail']['quantity_accepted']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($materialQualityCheckDetail['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($materialQualityCheckDetail['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($materialQualityCheckDetail['MaterialQualityCheckDetail']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;</td></tr>
                    <!--		<tr><td><?php echo __('Branch Ids'); ?></td>
                                    <td>
                <?php echo $this->Html->link($materialQualityCheckDetail['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $materialQualityCheckDetail['BranchIds']['id'])); ?>
                                            &nbsp;
                                    </td></tr>
                                    <tr><td><?php echo __('Department Ids'); ?></td>
                                    <td>
                <?php echo $this->Html->link($materialQualityCheckDetail['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $materialQualityCheckDetail['DepartmentIds']['id'])); ?>
                                            &nbsp;
                                    </td></tr>
                                    <tr><td><?php echo __('Company'); ?></td>
                                    <td>
                <?php echo $this->Html->link($materialQualityCheckDetail['Company']['name'], array('controller' => 'companies', 'action' => 'view', $materialQualityCheckDetail['Company']['id'])); ?>
                                            &nbsp;
                                    </td></tr>-->
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $materialQualityCheckDetail['MaterialQualityCheckDetail']['created_by'], 'recordId' => $materialQualityCheckDetail['MaterialQualityCheckDetail']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php echo $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#materialQualityCheckDetails_ajax'))); ?>

    <?php echo $this->Js->get('#edit'); ?>
<?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $materialQualityCheckDetail['MaterialQualityCheckDetail']['id'], 'ajax'), array('async' => true, 'update' => '#materialQualityCheckDetails_ajax'))); ?>


<?php echo $this->Js->writeBuffer(); ?>

</div>
<script>$.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});</script>
