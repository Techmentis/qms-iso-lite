<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="proposals ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Proposals', 'modelClass' => 'Proposal', 'options' => array("sr_no" => "Sr No", "title" => "Title", "proposal_heading" => "Proposal Heading", "proposal_details" => "Proposal Details"), 'pluralVar' => 'proposals'))); ?>

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
                    <th><?php echo $this->Paginator->sort('title'); ?></th>
                    <th><?php echo $this->Paginator->sort('customer_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('employee_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('proposal_heading'); ?></th>
                    <th style="min-width: 150px"><?php echo __('Follow Ups'); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish'); ?></th>
                </tr>
                <?php if ($proposals) {
                        $x = 0;
                        foreach ($proposals as $proposal):
                            $c = $this->requestAction('ProposalFollowups/followup_count/' . $proposal['Proposal']['id']);
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $proposal['Proposal']['created_by'], 'postVal' => $proposal['Proposal']['id'], 'softDelete' => $proposal['Proposal']['soft_delete'])); ?>
                    </td>
                    <td><?php echo h($proposal['Proposal']['title']); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($proposal['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $proposal['Customer']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($proposal['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $proposal['Employee']['id'])); ?>
                    </td>
                    <td>
                        <?php echo h($proposal['Proposal']['proposal_heading']); ?>&nbsp;</td>
                    <?php
                    if ($proposal['Proposal']['active_lock'] == 1) {
                        if (($proposal['Proposal']['created_by'] == $this->Session->read('User.id') || ($this->Session->read('User.is_mr') == true))) {
                            ?>
                            <td>
                                <div class="btn-group">
                                    <?php echo $this->Html->link('Add Followup', array('controller' => 'proposal_followups', 'action' => 'lists', $proposal['Proposal']['id']), array('class' => 'btn btn-group btn-sm btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')); ?>
                                    <?php echo $this->Html->link($c, '#', array('id' => 'count', 'class' => 'btn btn-group btn-sm btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')); ?><script>$('#count').tooltip();</script>
                                </div>&nbsp;

                            </td>
                        <?php } else { ?>
                            <td>
                                <div class="btn-group">
                                    <?php echo $this->Html->link('Not Allowed', '#', array('class' => 'btn btn-group btn-sm btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')); ?>
                                </div>&nbsp;<?php } ?>
                        <?php } else { ?>
                        <td>
                            <div class="btn-group">
                                <?php echo $this->Html->link('Add Followup', array('controller' => 'proposal_followups', 'action' => 'lists', $proposal['Proposal']['id']), array('class' => 'btn btn-group btn-sm btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')); ?>
                                <?php echo $this->Html->link($c, '#', array('id' => 'count', 'class' => 'btn btn-group btn-sm btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')); ?><script>$('#count').tooltip();</script>
                            </div>&nbsp;

                        <?php } ?>
                    </td>
                        <td><?php echo h($PublishedEmployeeList[$proposal['Proposal']['prepared_by']]); ?>&nbsp;</td>
                        <td><?php echo h($PublishedEmployeeList[$proposal['Proposal']['approved_by']]); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($proposal['Proposal']['publish'] == 1) { ?>
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
                <tr><td colspan=18>No results found</td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "proposal_heading" => "Proposal Heading", "proposal_details" => "Proposal Details"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "proposal_heading" => "Proposal Heading", "proposal_details" => "Proposal Details"))); ?>
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