<div id="listOfComputerListOfSoftwares_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="listOfComputerListOfSoftwares form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Computer Software'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Computer Name'); ?></td>
                    <td>
                        <?php echo $this->Html->link($listOfComputerListOfSoftware['ListOfComputer']['name'], array('controller' => 'list_of_computers', 'action' => 'view', $listOfComputerListOfSoftware['ListOfComputer']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Software Name'); ?></td>
                    <td>
                        <?php echo $this->Html->link($listOfComputerListOfSoftware['ListOfSoftware']['name'], array('controller' => 'list_of_softwares', 'action' => 'view', $listOfComputerListOfSoftware['ListOfSoftware']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Installation Date'); ?></td>
                    <td>
                        <?php echo h($listOfComputerListOfSoftware['ListOfComputerListOfSoftware']['installation_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Other Details'); ?></td>
                    <td>
                        <?php echo h($listOfComputerListOfSoftware['ListOfComputerListOfSoftware']['other_details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($listOfComputerListOfSoftware['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($listOfComputerListOfSoftware['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($listOfComputerListOfSoftware['ListOfComputerListOfSoftware']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $listOfComputerListOfSoftware['ListOfComputerListOfSoftware']['created_by'], 'recordId' => $listOfComputerListOfSoftware['ListOfComputerListOfSoftware']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#listOfComputerListOfSoftwares_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $listOfComputerListOfSoftware['ListOfComputerListOfSoftware']['id'], 'ajax'), array('async' => true, 'update' => '#listOfComputerListOfSoftwares_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#listOfComputerListOfSoftwares_ajax'))); ?>
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
