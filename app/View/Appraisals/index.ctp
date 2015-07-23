<?php echo $this->element('checkbox-script'); ?>
<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="appraisals ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Appraisals', 'modelClass' => 'Appraisal', 'options' => array("sr_no" => "Sr No", "Date" => "Date", "appraiser_by" => "Appraiser By", "reason" => "Reason", "self_appraisal_needed" => "Self Appraisal Needed", "self_appraisal_status" => "Self Appraisal Status", "rating" => "Rating", "employee_comments" => "Employee Comments", "appraiser_comments" => "Appraiser Comments", "final_result" => "Final Result", "specific_requirement" => "Specific Requirement", "increament" => "Increament"), 'pluralVar' => 'appraisals'))); ?>

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
                    <th><?php echo $this->Paginator->sort('employee_id', __('Employee')); ?></th>
                    <th><?php echo $this->Paginator->sort('appraisal_date', __('Appraisal Date')); ?></th>
                    <th><?php echo $this->Paginator->sort('appraiser_by', __('Appraiser')); ?></th>
                    <th><?php echo $this->Paginator->sort('self_appraisal_needed', __('Self Appraisal Needed')); ?></th>
                    <th><?php echo $this->Paginator->sort('self_appraisal_status', __('Self Appraisal Status')); ?></th>
                    <th><?php echo __('Appraisal Review'); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php if ($appraisals) {
                        $x = 0;
                        foreach ($appraisals as $appraisal):
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $appraisal['Appraisal']['created_by'], 'postVal' => $appraisal['Appraisal']['id'], 'softDelete' => $appraisal['Appraisal']['soft_delete'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($appraisal['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $appraisal['Employee']['id'])); ?>
                    </td>
                    <td><?php echo h($appraisal['Appraisal']['appraisal_date']); ?>&nbsp;</td>
                    <td><?php echo h($appraisal['AppraiserBy']['name']); ?>&nbsp;</td>
                    <td><?php echo h($appraisal['Appraisal']['self_appraisal_needed'] ? __('Yes') : __('No')); ?>&nbsp;</td>
                    <td><?php echo h($appraisal['Appraisal']['self_appraisal_status'] ? __('Done') : __('Pending')); ?>&nbsp;</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <?php
                                $currentDate = strtotime(date('Y-m-d'));
                                $appraisalDate = strtotime($appraisal['Appraisal']['appraisal_date']);
                                if ($currentDate <= $appraisalDate) {
                                    echo $this->Html->link('Review', array('action' => ''), array('class' => 'btn btn-group btn-sm btn-danger muted disabled'));
                                } else {
                                    echo $this->Html->link('Review', array('action' => 'appraisal_review', $appraisal['Appraisal']['id']), array('class' => 'btn btn-group btn-sm btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total'));
                                }
                            ?>
                        </div>
                    </td>
                    <td><?php echo h($PublishedEmployeeList[$appraisal['Appraisal']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$appraisal['Appraisal']['approved_by']]); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($appraisal['Appraisal']['publish'] == 1) { ?>
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
                <tr><td colspan='13'><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "Date" => "Date", "appraiser_by" => "Appraiser By", "reason" => "Reason", "self_appraisal_needed" => "Self Appraisal Needed", "self_appraisal_status" => "Self Appraisal Status", "rating" => "Rating", "employee_comments" => "Employee Comments", "appraiser_comments" => "Appraiser Comments", "final_result" => "Final Result", "specific_requirement" => "Specific Requirement", "increament" => "Increament"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "Date" => "Date", "appraiser_by" => "Appraiser By", "reason" => "Reason", "self_appraisal_needed" => "Self Appraisal Needed", "self_appraisal_status" => "Self Appraisal Status", "rating" => "Rating", "employee_comments" => "Employee Comments", "appraiser_comments" => "Appraiser Comments", "final_result" => "Final Result", "specific_requirement" => "Specific Requirement", "increament" => "Increament"))); ?>
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