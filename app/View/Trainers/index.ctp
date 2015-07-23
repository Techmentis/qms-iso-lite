
<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="trainers ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Trainers', 'modelClass' => 'Trainer', 'options' => array("sr_no" => "Sr No", "trainer_type" => "Trainer Type", "name" => "Name", "company" => "Company", "designation" => "Designation", "qualification" => "Qualification", "personal_telephone" => "Personal Telephone", "office_telephone" => "Office Telephone", "mobile" => "Mobile", "personal_email" => "Personal Email", "office_email" => "Office Email"), 'pluralVar' => 'trainers'))); ?>

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
                    <th><?php echo $this->Paginator->sort('trainer_type', __('Trainer Type')); ?></th>
                    <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                    <th><?php echo $this->Paginator->sort('company', __('Company')); ?></th>
                    <th><?php echo $this->Paginator->sort('designation', __('Designation')); ?></th>
                    <th><?php echo $this->Paginator->sort('qualification', __('Qualification')); ?></th>
                    <th><?php echo $this->Paginator->sort('office_telephone', __('Office Telephone')); ?></th>
                    <th><?php echo $this->Paginator->sort('mobile', __('Mobile')); ?></th>
                    <th><?php echo $this->Paginator->sort('office_email', __('Office Email')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php if ($trainers) {
                        $x = 0;
                        foreach ($trainers as $trainer):
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $trainer['Trainer']['created_by'], 'postVal' => $trainer['Trainer']['id'], 'softDelete' => $trainer['Trainer']['soft_delete'])); ?>
                    </td>
                    <td><?php echo $trainer['TrainerType']['title']; ?>&nbsp;</td>
                    <td><?php echo $trainer['Trainer']['name']; ?>&nbsp;</td>
                    <td><?php echo $trainer['Trainer']['company']; ?>&nbsp;</td>
                    <td><?php echo $trainer['Trainer']['designation']; ?>&nbsp;</td>
                    <td><?php echo $trainer['Trainer']['qualification']; ?>&nbsp;</td>
                    <td><?php echo $trainer['Trainer']['office_telephone']; ?>&nbsp;</td>
                    <td><?php echo $trainer['Trainer']['mobile']; ?>&nbsp;</td>
                    <td><?php echo $trainer['Trainer']['office_email']; ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$trainer['Trainer']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$trainer['Trainer']['approved_by']]); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($trainer['Trainer']['publish'] == 1) { ?>
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
                <tr><td colspan=22><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("trainer_type" => "Trainer Type", "name" => "Name", "company" => "Company", "designation" => "Designation", "qualification" => "Qualification", "personal_telephone" => "Personal Telephone", "office_telephone" => "Office Telephone", "mobile" => "Mobile", "personal_email" => "Personal Email", "office_email" => "Office Email"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "trainer_type" => "Trainer Type", "name" => "Name", "company" => "Company", "designation" => "Designation", "qualification" => "Qualification", "personal_telephone" => "Personal Telephone", "office_telephone" => "Office Telephone", "mobile" => "Mobile", "personal_email" => "Personal Email", "office_email" => "Office Email"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
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