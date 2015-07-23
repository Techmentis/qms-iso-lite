<div id="fireExtinguishers_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="fireExtinguishers form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Fire Extinguisher'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo $fireExtinguisher['FireExtinguisher']['sr_no']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Name'); ?></td>
                    <td>
                        <?php echo $fireExtinguisher['FireExtinguisher']['name']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Fire Extinguisher Type'); ?></td>
                    <td>
                        <?php echo $this->Html->link($fireExtinguisher['FireExtinguisherType']['name'], array('controller' => 'fire_extinguisher_types', 'action' => 'view', $fireExtinguisher['FireExtinguisherType']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Company Name'); ?></td>
                    <td>
                        <?php echo $fireExtinguisher['FireExtinguisher']['company_name']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Description'); ?></td>
                    <td>
                        <?php echo $fireExtinguisher['FireExtinguisher']['description']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Purchase Date'); ?></td>
                    <td>
                        <?php echo $fireExtinguisher['FireExtinguisher']['purchase_date']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Expiry Date'); ?></td>
                    <td>
                        <?php echo $fireExtinguisher['FireExtinguisher']['expeiry_date']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Warranty Expiry Date'); ?></td>
                    <td>
                        <?php echo $fireExtinguisher['FireExtinguisher']['warrenty_expiry_date']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Model Type'); ?></td>
                    <td>
                        <?php echo $fireExtinguisher['FireExtinguisher']['model_type']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Other Remarks'); ?></td>
                    <td>
                        <?php echo $fireExtinguisher['FireExtinguisher']['other_remarks']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo $fireExtinguisher['PreparedBy']['name']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo $fireExtinguisher['ApprovedBy']['name']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($fireExtinguisher['FireExtinguisher']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $fireExtinguisher['FireExtinguisher']['created_by'], 'recordId' => $fireExtinguisher['FireExtinguisher']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#fireExtinguishers_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $fireExtinguisher['FireExtinguisher']['id'], 'ajax'), array('async' => true, 'update' => '#fireExtinguishers_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#fireExtinguishers_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>
