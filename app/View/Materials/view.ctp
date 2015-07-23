<div id="materials_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="materials form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Material'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($material['Material']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Name'); ?></td>
                    <td>
                        <?php echo h($material['Material']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Description'); ?></td>
                    <td>
                        <?php echo h($material['Material']['description']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Shelflife By Manufacturer'); ?></td>
                    <td>
                        <?php echo h($material['MaterialListWithShelfLife'][0]['shelflife_by_manufacturer']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Shelflife By Company'); ?></td>
                    <td>
                        <?php echo h($material['MaterialListWithShelfLife'][0]['shelflife_by_company']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Material QC Required?'); ?></td>
                    <td>
                        <?php echo h($material['Material']['qc_required']) ? __('Yes') : __('No'); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Remarks'); ?></td>
                    <td>
                        <?php echo h($material['MaterialListWithShelfLife'][0]['remarks']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($material['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($material['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($material['Material']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php if (!empty($material['MaterialQualityCheck'])) { ?>
                <h4 class="alert alert-warning">
                    <?php
                        $i = 0;
                        echo __('Material Quality Check Required');
                    ?>
                </h4><hr>
                    <?php foreach ($material['MaterialQualityCheck'] as $materialQualityCheck): ?>
                    <b><?php
                            echo __('Step - ');
                            echo ++$i;
                        ?>
                    </b>
                    <table class="table table-responsive">
                        <tr>
                            <td><?php echo __('Name'); ?></td>
                            <td><?php echo h($materialQualityCheck['name']); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><?php echo __('Details'); ?></td>
                            <td><?php echo h($materialQualityCheck['details']); ?>&nbsp;</td>
                        </tr>
                    </table>
            <?php
                endforeach;
            }
            ?>
				<?php //echo $this->element('upload-edit', array('usersId' => $employee['Employee']['created_by'], 'recordId' => $employee['Employee']['id'])); ?>
				<?php echo $this->element('upload-edit', array('usersId' => $material['Material']['created_by'], 'recordId' => $material['Material']['id'])); ?>
            </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#materials_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $material['Material']['id'], 'ajax'), array('async' => true, 'update' => '#materials_ajax'))); ?>

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
