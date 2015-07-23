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
                    <th></th>
                    <th></th>
                    <th><?php echo $this->Paginator->sort('sr_no', __('Sr. No')); ?></th>
                    <th><?php echo $this->Paginator->sort('title'); ?></th>
                    <th><?php echo $this->Paginator->sort('document_number'); ?></th>
                    <th><?php echo $this->Paginator->sort('issue_number'); ?></th>
                    <th><?php echo $this->Paginator->sort('revision_number'); ?></th>
                    <th><?php echo $this->Paginator->sort('revision_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('archived'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($masterListOfFormats) {
                        foreach ($masterListOfFormats as $masterListOfFormat):
                ?>
                <tr>
                    <td width="15"><?php echo $this->Form->checkbox('rec_ids_' . $i, array('label' => false, 'value' => $masterListOfFormat['MasterListOfFormat']['id'], 'multiple' => 'checkbox', 'class' => 'rec_ids')); ?></td>		<td class=" actions">
                        <div class="btn-group">
                            <button type="button" data-toggle="dropdown" class="dropdown-toggle btn  btn-sm btn-default "><span class=" glyphicon glyphicon-wrench"></span></button>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><?php echo $this->Html->link(__('View / Upload Evidance'), array('action' => 'view', $masterListOfFormat['MasterListOfFormat']['id'])); ?></li>
                                <li><?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $masterListOfFormat['MasterListOfFormat']['id'])); ?></li>
                                <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $masterListOfFormat['MasterListOfFormat']['id']), array('class' => ''), __('Are you sure you want to delete this record ?', $masterListOfFormat['MasterListOfFormat']['id'])); ?></li>
                                <li class="divider"></li>
                                <li><?php echo $this->Form->postLink(__('Email Record'), array('controller' => 'message', 'action' => 'add', $masterListOfFormat['MasterListOfFormat']['id']), array('class' => ''), __('Are you sure ?', $masterListOfFormat['MasterListOfFormat']['id'])); ?></li>
                            </ul>
                        </div>
                    </td>
                    <td width="50"><?php echo h($masterListOfFormat['MasterListOfFormat']['sr_no']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['title']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['document_number']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['issue_number']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['revision_number']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['revision_date']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['prepared_by']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['approved_by']); ?>&nbsp;</td>
                    <td><?php echo h($masterListOfFormat['MasterListOfFormat']['archived']); ?>&nbsp;</td>

                    <td width="60">
                        <?php if ($masterListOfFormat['MasterListOfFormat']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                </tr>
                <?php
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
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "document_number" => "Document Number", "issue_number" => "Issue Number", "revision_number" => "Revision Number", "revision_date" => "Revision Date", "prepared_by" => "Prepared By", "approved_by" => "Approved By", "archived" => "Archived"))); ?>
<?php echo $this->element('export'); ?>
<?php echo $this->element('approvals'); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>