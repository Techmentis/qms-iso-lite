<div id="nonConformingProductsMaterials_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel">
        <div class="nonConformingProductsMaterials form col-md-8">
            <h4><?php echo __('View Non Conforming Products Material'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($nonConformingProductsMaterial['NonConformingProductsMaterial']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Title'); ?></td>
                    <td>
                        <?php echo h($nonConformingProductsMaterial['NonConformingProductsMaterial']['title']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Description'); ?></td>
                    <td>
                        <?php echo h($nonConformingProductsMaterial['NonConformingProductsMaterial']['description']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Material'); ?></td>
                    <td>
                        <?php echo $this->Html->link($nonConformingProductsMaterial['Material']['name'], array('controller' => 'materials', 'action' => 'view', $nonConformingProductsMaterial['Material']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Product'); ?></td>
                    <td>
                        <?php echo $this->Html->link($nonConformingProductsMaterial['Product']['name'], array('controller' => 'products', 'action' => 'view', $nonConformingProductsMaterial['Product']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Capa Source'); ?></td>
                    <td>
                        <?php echo $this->Html->link($nonConformingProductsMaterial['CapaSource']['name'], array('controller' => 'capa_sources', 'action' => 'view', $nonConformingProductsMaterial['CapaSource']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Corrective Preventive Action'); ?></td>
                    <td>
                        <?php echo $this->Html->link($nonConformingProductsMaterial['CorrectivePreventiveAction']['name'], array('controller' => 'corrective_preventive_actions', 'action' => 'view', $nonConformingProductsMaterial['CorrectivePreventiveAction']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($nonConformingProductsMaterial['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($nonConformingProductsMaterial['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($nonConformingProductsMaterial['NonConformingProductsMaterial']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $nonConformingProductsMaterial['NonConformingProductsMaterial']['created_by'], 'recordId' => $nonConformingProductsMaterial['NonConformingProductsMaterial']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#nonConformingProductsMaterials_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $nonConformingProductsMaterial['NonConformingProductsMaterial']['id'], 'ajax'), array('async' => true, 'update' => '#nonConformingProductsMaterials_ajax'))); ?>
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
