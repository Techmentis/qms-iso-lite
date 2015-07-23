<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="reports ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Reports', 'modelClass' => 'Report', 'options' => array("sr_no" => "Sr No", "title" => "Title", "description" => "Description", "details" => "Details", "report_date" => "Report Date"), 'pluralVar' => 'reports'))); ?>

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
                    <th colspan="2" ><input type="checkbox" id="selectAll"></th>
                    <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                    <th>description</th>
                    <th>report date</th>
                    <th>Master list of format</th>
                    <th>Department</th>
                    <th>Branch</th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php if ($reports) {
                        $x = 0;
                        foreach ($reports as $report):
                ?>
                <tr>
                    <td class=" actions" colspan="2">
                        <?php echo $this->element('actions', array('created' => $report['Report']['created_by'], 'postVal' => $report['Report']['id'], 'softDelete' => $report['Report']['soft_delete'])); ?>
                    </td>
                    <td><a href="<?php echo Router::url('/', true) . "/" . $report['Report']['details']; ?>"><?php echo $report['Report']['title']; ?></a>&nbsp;</td>
                    <td><?php echo $report['Report']['description']; ?>&nbsp;</td>

                    <td><?php echo $report['Report']['report_date']; ?>&nbsp;</td>
                    <td><?php echo $report['MasterListOfFormat']['title'] ?></td>
                    <td><?php echo $report['Department']['name']; ?>&nbsp;</td>
                    <td><?php echo $report['Branch']['name']; ?>&nbsp;</td>
                    <td><?php echo $report['ApprovedBy']['name']; ?>&nbsp;</td>
                    <td><?php echo $report['PreparedBy']['name']; ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($report['Report']['publish'] == 1) { ?>
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
                    <tr><td colspan=13><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "description" => "Description", "details" => "Details", "report_date" => "Report Date"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "description" => "Description", "details" => "Details", "report_date" => "Report Date", 'modelName' => $this->name))); ?>
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