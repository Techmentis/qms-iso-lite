<?php echo $this->element('checkbox-script'); ?>
<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="summeryOfSupplierEvaluations ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Summery Of Supplier Evaluations', 'modelClass' => 'SummeryOfSupplierEvaluation', 'options' => array("sr_no" => "Sr No", "remarks" => "Remarks", "evaluation_date" => "Evaluation Date"), 'pluralVar' => 'summeryOfSupplierEvaluations'))); ?>

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
                    <th><?php echo $this->Paginator->sort('supplier_registration_id', __('Supplier')); ?></th>
                    <th><?php echo $this->Paginator->sort('supplier_category_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('remarks'); ?></th>
                    <th><?php echo $this->Paginator->sort('evaluation_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('employee_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish'); ?></th>
                </tr>
                <?php if ($summeryOfSupplierEvaluations) {
                        $x = 0;
                        foreach ($summeryOfSupplierEvaluations as $summeryOfSupplierEvaluation):
                ?>
                <tr>

                    <td class=" actions">
                        <?php echo $this->element('actions', array('postVal' => $summeryOfSupplierEvaluation['SummeryOfSupplierEvaluation']['id'], 'softDelete' => $summeryOfSupplierEvaluation['SummeryOfSupplierEvaluation']['soft_delete'], 'created' => $summeryOfSupplierEvaluation['SummeryOfSupplierEvaluation']['created'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($summeryOfSupplierEvaluation['SupplierRegistration']['title'], array('controller' => 'supplier_registrations', 'action' => 'view', $summeryOfSupplierEvaluation['SupplierRegistration']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($summeryOfSupplierEvaluation['SupplierCategory']['name'], array('controller' => 'supplier_categories', 'action' => 'view', $summeryOfSupplierEvaluation['SupplierCategory']['id'])); ?>
                    </td>
                    <td><?php echo h($summeryOfSupplierEvaluation['SummeryOfSupplierEvaluation']['remarks']); ?>&nbsp;</td>
                    <td><?php echo h($summeryOfSupplierEvaluation['SummeryOfSupplierEvaluation']['evaluation_date']); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($summeryOfSupplierEvaluation['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $summeryOfSupplierEvaluation['Employee']['id'])); ?>
                    </td>
                    <td><?php echo h($summeryOfSupplierEvaluation['PreparedBy']['name']); ?>&nbsp;</td>
                    <td><?php echo h($summeryOfSupplierEvaluation['ApprovedBy']['name']); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($summeryOfSupplierEvaluation['SummeryOfSupplierEvaluation']['publish'] == 1) { ?>
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
                <tr><td colspan=17>No results found</td></tr>
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
<?php echo $this->element('common'); ?>
<?php echo $this->element('advanced-search', array('postData' => array("remarks" => "Remarks", "evaluation_date" => "Evaluation Date"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "remarks" => "Remarks", "evaluation_date" => "Evaluation Date"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->Js->writeBuffer(); ?>

<script>
    $.ajaxSetup({
        beforeSend: function () {
            $("#busy-indicator").show();
        },
        complete: function () {
            $("#busy-indicator").hide();
        }
    });
</script>