<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="masterListOfFormats ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Master List Of Formats', 'modelClass' => 'MasterListOfFormat', 'options' => array("sr_no" => "Sr No", "title" => "Title", "document_number" => "Document Number", "issue_number" => "Issue Number", "revision_number" => "Revision Number", "revision_date" => "Revision Date", "prepared_by" => "Prepared By", "approved_by" => "Approved By", "archived" => "Archived"), 'pluralVar' => 'masterListOfFormats'))); ?>

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
                    <th><?php echo $this->Paginator->sort('document_number'); ?></th>
                    <th><?php echo $this->Paginator->sort('issue_number'); ?></th>
                    <th><?php echo $this->Paginator->sort('revision_number'); ?></th>
                    <th><?php echo $this->Paginator->sort('revision_date'); ?></th>
                    <th><?php echo __('Branch') ?></th>
                    <th><?php echo __('Departments') ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('archived'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($masterListOfFormats) {
                        $x = 0;
                        foreach ($masterListOfFormats as $masterListOfFormat):
                ?>
                <tr>

                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $masterListOfFormat['MasterListOfFormat']['created_by'], 'postVal' => $masterListOfFormat['MasterListOfFormat']['id'], 'softDelete' => $masterListOfFormat['MasterListOfFormat']['soft_delete'])); ?>
                    </td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['title']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['document_number']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['issue_number']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['revision_number']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['revision_date']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['Branches']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['Departments']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['PreparedBy']['name']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['ApprovedBy']['name']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['archived']) ? __('Yes') : __('No'); ?>&nbsp;</td>

                    <td width="60">
                        <?php if ($masterListOfFormat['MasterListOfFormat']['publish'] == 1) { ?>
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
                <tr><td colspan=19><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "document_number" => "Document Number", "issue_number" => "Issue Number", "revision_number" => "Revision Number", "revision_date" => "Revision Date", "prepared_by" => "Prepared By", "approved_by" => "Approved By", "archived" => "Archived"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "document_number" => "Document Number", "issue_number" => "Issue Number", "revision_number" => "Revision Number", "revision_date" => "Revision Date", "prepared_by" => "Prepared By", "approved_by" => "Approved By", "archived" => "Archived", 'modelName' => $this->name))); ?>
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