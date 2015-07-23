<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="fireExtinguishers ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Fire Extinguishers', 'modelClass' => 'FireExtinguisher', 'options' => array("sr_no" => "Sr No", "name" => "Name", "company_name" => "Company Name", "description" => "Description", "purchase_date" => "Purchase Date", "expeiry_date" => "Expeiry Date", "warrenty_expiry_date" => "Warranty Expiry Date", "model_type" => "Model Type", "other_remarks" => "Other Remarks"), 'pluralVar' => 'fireExtinguishers'))); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#main').load(url);
            return false;
        });
    });
</script>
        <div class="table-responsive">
            <?php echo $this->Form->create(array('class' => 'no-padding no-margin no-background')); ?>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                    <th><?php echo $this->Paginator->sort('fire_extinguisher_type_id', __('Fire Extinguisher Type')); ?></th>
                    <th><?php echo $this->Paginator->sort('company_name', __('Company Name')); ?></th>
                    <th><?php echo $this->Paginator->sort('purchase_date', __('Purchase Date')); ?></th>
                    <th><?php echo $this->Paginator->sort('expeiry_date', __('Expiry Date')); ?></th>
                    <th><?php echo $this->Paginator->sort('warrenty_expiry_date', __('Warranty Expiry Date')); ?></th>
                    <th><?php echo $this->Paginator->sort('model_type', __('Model Type')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($fireExtinguishers) {
                        $x = 0;
                        foreach ($fireExtinguishers as $fireExtinguisher):
                ?>
                <tr>

                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $fireExtinguisher['FireExtinguisher']['created_by'], 'postVal' => $fireExtinguisher['FireExtinguisher']['id'], 'softDelete' => $fireExtinguisher['FireExtinguisher']['soft_delete'])); ?>
                    </td>
                    <td><?php echo $fireExtinguisher['FireExtinguisher']['name']; ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($fireExtinguisher['FireExtinguisherType']['name'], array('controller' => 'fire_extinguisher_types', 'action' => 'view', $fireExtinguisher['FireExtinguisherType']['id'])); ?>
                    </td>
                    <td><?php echo $fireExtinguisher['FireExtinguisher']['company_name']; ?>&nbsp;</td>
                    <td><?php echo $fireExtinguisher['FireExtinguisher']['purchase_date']; ?>&nbsp;</td>
                    <td><?php echo $fireExtinguisher['FireExtinguisher']['expeiry_date']; ?>&nbsp;</td>
                    <td><?php echo $fireExtinguisher['FireExtinguisher']['warrenty_expiry_date']; ?>&nbsp;</td>
                    <td><?php echo $fireExtinguisher['FireExtinguisher']['model_type']; ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$fireExtinguisher['FireExtinguisher']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$fireExtinguisher['FireExtinguisher']['approved_by']]); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($fireExtinguisher['FireExtinguisher']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                </tr>
                <?php
                    $x++;
                    endforeach;
                    } else {
                ?>
                <tr><td colspan=21><?php echo __('No results found'); ?></td></tr>
                <?php } ?>
            </table>
            <?php echo $this->Form->end(); ?>
        </div>
        <p>
            <?php
                echo $this->Paginator->options(array(
                    'update' => '#main',
                    'evalScripts' => true,
                    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
                    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
                ));

                echo $this->Paginator->counter(array(
                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                ));
            ?>
        </p>
        <ul class="pagination">
            <?php
                echo "<li class='previous'>" . $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) . "</li>";
                echo "<li>" . $this->Paginator->numbers(array('separator' => '')) . "</li>";
                echo "<li class='next'>" . $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')) . "</li>";
            ?>
        </ul>
    </div>
</div>

<?php echo $this->element('export'); ?>
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "company_name" => "Company Name", "description" => "Description", "purchase_date" => "Purchase Date", "expeiry_date" => "Expeiry Date", "warrenty_expiry_date" => "Warranty Expiry Date", "model_type" => "Model Type", "other_remarks" => "Other Remarks"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "company_name" => "Company Name", "description" => "Description", "purchase_date" => "Purchase Date", "expeiry_date" => "Expeiry Date", "warrenty_expiry_date" => "Warranty Expiry Date", "model_type" => "Model Type", "other_remarks" => "Other Remarks"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
<?php echo $this->Js->writeBuffer(); ?>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>