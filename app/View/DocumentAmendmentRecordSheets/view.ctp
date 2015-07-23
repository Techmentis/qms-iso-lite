<div id="documentAmendmentRecordSheets_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="documentAmendmentRecordSheets form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Document Amendment Record Sheet'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Request From'); ?></td>
                    <td>
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['branch_id'] != -1) echo "<strong>Branch : </strong>" . h($documentAmendmentRecordSheet['Branch']['name']); ?>
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['department_id'] != -1) echo "<strong>Department : </strong>" . h($documentAmendmentRecordSheet['Department']['name']); ?>
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['employee_id'] != -1) echo "<strong>Employee : </strong>" . h($documentAmendmentRecordSheet['Employee']['name']); ?>
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['customer_id'] != -1) echo "<strong>Customer : </strong>" . h($documentAmendmentRecordSheet['Customer']['name']); ?>
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['suggestion_form_id'] != -1) echo "<strong>Suggestion Form : </strong>" . h($documentAmendmentRecordSheet['SuggestionForm']['title']); ?>
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['others'] != '') echo "<strong>Other : </strong>" . h($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['others']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Master List Of Format'); ?></td>
                    <td>
                        <?php echo h($documentAmendmentRecordSheet['MasterListOfFormatID']['title']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Document Number'); ?></td>
                    <td>
                        <?php echo h($documentAmendmentRecordSheet['MasterListOfFormatID']['document_number']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Issue Number'); ?></td>
                    <td>
                        <?php echo h($documentAmendmentRecordSheet['MasterListOfFormatID']['issue_number']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Revision Number'); ?></td>
                    <td>
                        <?php echo h($documentAmendmentRecordSheet['MasterListOfFormatID']['revision_number']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Revision Date'); ?></td>
                    <td>
                        <?php echo h($documentAmendmentRecordSheet['MasterListOfFormatID']['revision_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($PublishedEmployeeList[$documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['prepared_by']]); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($PublishedEmployeeList[$documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['approved_by']]); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Amendment Details'); ?></td>
                    <td>
                        <?php echo h($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['amendment_details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Reason For Change'); ?></td>
                    <td>
                        <?php echo h($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['reason_for_change']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($documentAmendmentRecordSheet['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($documentAmendmentRecordSheet['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('document_amendment_record_sheets_files_view', array('usersId' => $documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['created_by'], 'recordId' => $documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
        <div class="col-md-12">
            <h4><?php echo __("Current Document") ?></h4>
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <th><?php echo __("Document Title") ?></th>
                    <th><?php echo __("Document Number") ?></th>
                    <th><?php echo __("Revision Number") ?></th>
                    <th><?php echo __("Revision Date") ?></th>
                    <th><?php echo __("Prepared By") ?></th>
                    <th><?php echo __("Approved By") ?></th>
                </tr>
                <tr>
                    <td><?php echo $firstDocument['MasterListOfFormat']['title'] ?></td>
                    <td><?php echo $firstDocument['MasterListOfFormat']['document_number'] ?></td>
                    <td><?php echo $firstDocument['MasterListOfFormat']['revision_number'] ?></td>
                    <td><?php echo $firstDocument['MasterListOfFormat']['revision_date'] ?></td>
                    <td><?php echo $firstDocument['PreparedBy']['name'] ?></td>
                    <td><?php echo $firstDocument['ApprovedBy']['name'] ?></td>
                </tr>
            <tr>
            	<td colspan="6"><h4><?php echo __("Amendment History") ?></h4></td>
            </tr>
                <tr>
                    <th><?php echo __("Document Title") ?></th>
                    <th><?php echo __("Document Number") ?></th>
                    <th><?php echo __("Revision Number") ?></th>
                    <th><?php echo __("Revision Date") ?></th>
                    <th><?php echo __("Prepared By") ?></th>
                    <th><?php echo __("Approved By") ?></th>
                </tr>
                <?php foreach($revisionHistorys as $revisionHistory): ?>
                <tr>
                    <td><?php echo $this->Html->link($firstDocument['MasterListOfFormat']['title'],array('action'=>'view',$revisionHistory['DocumentAmendmentRecordSheet']['id'])) ?></td>
                    <td><?php echo $revisionHistory['DocumentAmendmentRecordSheet']['document_number'] ?></td>
                    <td><?php echo $revisionHistory['DocumentAmendmentRecordSheet']['revision_number'] ?></td>
                    <td><?php echo $revisionHistory['DocumentAmendmentRecordSheet']['revision_date'] ?></td>
                    <td><?php echo $revisionHistory['PreparedBy']['name'] ?></td>
                    <td><?php echo $revisionHistory['ApprovedBy']['name'] ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#documentAmendmentRecordSheets_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['id'], 'ajax'), array('async' => true, 'update' => '#documentAmendmentRecordSheets_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#documentAmendmentRecordSheets_ajax'))); ?>
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
