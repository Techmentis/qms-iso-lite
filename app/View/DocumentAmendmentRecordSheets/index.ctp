<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="documentAmendmentRecordSheets ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Document Amendment Record Sheets', 'modelClass' => 'DocumentAmendmentRecordSheet', 'options' => array("sr_no" => "Sr No", "request_from" => "Request From", "others" => "Others", "master_list_of_format" => "Master List Of Format", "amendment_details" => "Amendment Details", "reason_for_change" => "Reason For Change"), 'pluralVar' => 'documentAmendmentRecordSheets'))); ?>

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
                    <th><?php echo $this->Paginator->sort('request_from'); ?></th>
                    <th><?php echo $this->Paginator->sort('master_list_of_format'); ?></th>
                    <th><?php echo __('Document Number'); ?></th>
                    <th><?php echo __('Issue Number'); ?></th>
                    <th><?php echo __('Revision Number'); ?></th>
                    <th><?php echo __('Revision Date'); ?></th>
                    <th><?php echo __('Prepared By'); ?></th>
                    <th><?php echo __('Approved By'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($documentAmendmentRecordSheets) {
                        $x = 0;
                        foreach ($documentAmendmentRecordSheets as $documentAmendmentRecordSheet):
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['created_by'], 'postVal' => $documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['id'], 'softDelete' => $documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['soft_delete'])); ?>
                    </td>
                    <td>
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['branch_id'] != -1) echo "<strong>Branch : </strong>" . $this->Html->link($documentAmendmentRecordSheet['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $documentAmendmentRecordSheet['Branch']['id'])); ?>
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['department_id'] != -1) echo "<strong>Department : </strong>" . $this->Html->link($documentAmendmentRecordSheet['Department']['name'], array('controller' => 'departments', 'action' => 'view', $documentAmendmentRecordSheet['Department']['id'])); ?>
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['employee_id'] != -1) echo "<strong>Employee : </strong>" . $this->Html->link($documentAmendmentRecordSheet['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $documentAmendmentRecordSheet['Employee']['id'])); ?>
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['customer_id'] != -1) echo "<strong>Customer : </strong>" . $this->Html->link($documentAmendmentRecordSheet['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $documentAmendmentRecordSheet['Customer']['id'])); ?>
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['suggestion_form_id'] != -1) echo "<strong>Suggestion Form : </strong>" . $this->Html->link($documentAmendmentRecordSheet['SuggestionForm']['title'], array('controller' => 'Suggestion_forms', 'action' => 'view', $documentAmendmentRecordSheet['SuggestionForm']['id'])); ?>
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['others'] != '') echo "<strong>Other : </strong>" . h($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['others']); ?>&nbsp;
                    </td>
                    <td><?php echo h($documentAmendmentRecordSheet['MasterListOfFormatID']['title']); ?>&nbsp;</td>
                    <td><?php echo h($documentAmendmentRecordSheet['MasterListOfFormatID']['document_number']); ?>&nbsp;</td>
                    <td><?php echo h($documentAmendmentRecordSheet['MasterListOfFormatID']['issue_number']); ?>&nbsp;</td>
                    <td><?php echo h($documentAmendmentRecordSheet['MasterListOfFormatID']['revision_number']); ?>&nbsp;</td>
                    <td><?php echo h($documentAmendmentRecordSheet['MasterListOfFormatID']['revision_date']); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['approved_by']]); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                </tr>
                <?php
                    $x++;
                    endforeach;
                ?>
                <?php } else { ?>
                    <tr><td colspan=23>No results found</td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "request_from" => "Request From", "others" => "Others", "master_list_of_format" => "Master List Of Format", "amendment_details" => "Amendment Details", "reason_for_change" => "Reason For Change"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "request_from" => "Request From", "others" => "Others", "master_list_of_format" => "Master List Of Format", "amendment_details" => "Amendment Details", "reason_for_change" => "Reason For Change"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
</div>
<?php echo $this->Js->writeBuffer(); ?>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>