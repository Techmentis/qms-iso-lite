<?php echo $this->element('checkbox-script'); ?>
<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="helps ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Helps', 'modelClass' => 'Help', 'options' => array("sr_no" => "Sr No", "title" => "Title", "table_name" => "Table Name", "action_name" => "Action Name", "help_text" => "Help Text", "sequence" => "Sequence"), 'pluralVar' => 'helps'))); ?>

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
                    <th><?php echo $this->Paginator->sort('language_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('title'); ?></th>
                    <th><?php echo $this->Paginator->sort('table_name'); ?></th>
                    <th><?php echo $this->Paginator->sort('action_name'); ?></th>
                    <th><?php echo $this->Paginator->sort('help_text'); ?></th>
                    <th><?php echo $this->Paginator->sort('sequence'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($sys_helps) {
                        $x = 0;
                        foreach ($sys_helps as $help):
                ?>
                <tr>

                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $help['Help']['created_by'], 'postVal' => $help['Help']['id'], 'softDelete' => $help['Help']['soft_delete'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($help['Language']['name'], array('controller' => 'languages', 'action' => 'view', $help['Language']['id'])); ?>
                    </td>
                    <td><?php echo h($help['Help']['title']); ?>&nbsp;</td>
                    <td><?php echo h($help['Help']['table_name']); ?>&nbsp;</td>
                    <td><?php echo h($help['Help']['action_name']); ?>&nbsp;</td>
                    <td><?php echo h($help['Help']['help_text']); ?>&nbsp;</td>
                    <td><?php echo h($help['Help']['sequence']); ?>&nbsp;</td>

                    <td width="60">
                        <?php if ($help['Help']['publish'] == 1) { ?>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "table_name" => "Table Name", "action_name" => "Action Name", "help_text" => "Help Text", "sequence" => "Sequence"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "table_name" => "Table Name", "action_name" => "Action Name", "help_text" => "Help Text", "sequence" => "Sequence"))); ?>
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