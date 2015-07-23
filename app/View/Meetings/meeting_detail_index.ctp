<?php echo $this->element('checkbox-script'); ?>

<div  id="main">

    <?php echo $this->Session->flash(); ?>
    <div class="meetings ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Meetings', 'modelClass' => 'Meeting', 'options' => array("sr_no" => "Sr No", "title" => "Title", "previous_meeting_date" => "Previous Meeting", "meeting_details" => "Meeting Details", "header" => "Header", "footer" => "Footer", "employee_by" => "Employee By"), 'pluralVar' => 'meetings'))); ?>

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
                    <th colspan="2"><input type="checkbox" id="selectAll"></th>
                    <th width="100"><?php echo $this->Paginator->sort('title', __('Title')); ?></th>
                    <th><?php echo $this->Paginator->sort('previous_meeting_date', __('Previous Meeting')); ?></th>
                    <th><?php echo $this->Paginator->sort('actual_meeting_from', __('Meeting From')); ?></th>
                    <th><?php echo $this->Paginator->sort('actual_meeting_to', __('Meeting To')); ?></th>
                    <th><?php echo $this->Paginator->sort('meeting_details', __('Meeting Details')); ?></th>
                    <th><?php echo $this->Paginator->sort('employee_by', __('Chairperson')); ?></th>
                    <th width="100"><?php echo __('Branch') ?></th>
                    <th><?php echo __('Departments') ?></th>
                    <th><?php echo __('Attendees') ?></th>
                    <th><?php echo __('Topic') ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php if ($meetings) {
                        $x = 0;
                        foreach ($meetings as $meeting):
                ?>
                <tr>
                    <td width="15"><?php echo $this->Form->checkbox('rec_ids_' . $x, array('label' => false, 'value' => $meeting['Meeting']['id'], 'multiple' => 'checkbox', 'class' => 'rec_ids', 'onClick' => 'getVals()')); ?></td>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('postVal' => $meeting['Meeting']['id'], 'softDelete' => $meeting['Meeting']['soft_delete'])); ?>
                    </td>
                    <td><?php echo h($meeting['Meeting']['title']); ?>&nbsp;</td>
                    <td><?php echo h($meeting['Meeting']['previous_meeting_date']); ?>&nbsp;</td>
                    <td><?php echo h($meeting['Meeting']['actual_meeting_from']); ?>&nbsp;</td>
                    <td><?php echo h($meeting['Meeting']['actual_meeting_to']); ?>&nbsp;</td>
                    <td width="200"><?php echo h($meeting['Meeting']['meeting_details']); ?>&nbsp;</td>
                    <td><?php echo h($meeting['Meeting']['employee_by']); ?>&nbsp;</td>
                    <td width="100"><?php echo h($meeting['Meeting']['Branches']); ?>&nbsp;</td>
                    <td width="100"><?php echo h($meeting['Meeting']['Departments']); ?>&nbsp;</td>
                    <td width="100"><?php echo h($meeting['Meeting']['Attendees']); ?>&nbsp;</td>
                    <td width="100"><?php echo h($meeting['Meeting']['Topics']); ?>&nbsp;</td>

                    <td width="60">
                        <?php if ($meeting['Meeting']['publish'] == 1) { ?>
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
                <tr><td colspan=18><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "previous_meeting_date" => "Previous Meeting", "meeting_details" => "Meeting Details", "header" => "Header", "footer" => "Footer", "employee_by" => "Employee By"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "previous_meeting_date" => "Previous Meeting", "meeting_details" => "Meeting Details", "header" => "Header", "footer" => "Footer", "employee_by" => "Employee By"))); ?>
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