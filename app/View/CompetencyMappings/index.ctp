<?php echo $this->element('checkbox-script'); ?>
<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="competencyMappings ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Competency Mappings', 'modelClass' => 'CompetencyMapping', 'options' => array("sr_no" => "Sr No", "experience_required" => "Experience Required", "skills_required" => "Skills Required", "actual_education" => "Actual Education", "actual_experience" => "Actual Experience", "skills_possesed" => "Skills Possessed", "remarks" => "Remarks"), 'pluralVar' => 'competencyMappings'))); ?>

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
                    <th><?php echo $this->Paginator->sort('employee_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('education_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('actual_education'); ?></th>
                    <th><?php echo $this->Paginator->sort('experience_required'); ?></th>
                    <th><?php echo $this->Paginator->sort('actual_experience'); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish'); ?></th>
                </tr>
                <?php
                    if ($competencyMappings) {
                    $x = 0;
                    foreach ($competencyMappings as $competencyMapping):
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $competencyMapping['CompetencyMapping']['created_by'], 'postVal' => $competencyMapping['CompetencyMapping']['id'], 'softDelete' => $competencyMapping['CompetencyMapping']['soft_delete'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($competencyMapping['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $competencyMapping['Employee']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($competencyMapping['Education']['title'], array('controller' => 'educations', 'action' => 'view', $competencyMapping['Education']['id'])); ?>
                    </td>
                    <td><?php echo h($competencyMapping['ActualEducation']['title']); ?>&nbsp;</td>
                    <td><?php echo h($competencyMapping['CompetencyMapping']['experience_required']); ?>&nbsp;</td>
                    <td><?php echo h($competencyMapping['CompetencyMapping']['actual_experience']); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$competencyMapping['CompetencyMapping']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$competencyMapping['CompetencyMapping']['approved_by']]); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($competencyMapping['CompetencyMapping']['publish'] == 1) { ?>
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
                <tr><td colspan=20>No results found</td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("experience_required" => "Experience Required", "skills_required" => "Skills Required", "actual_education" => "Actual Education", "actual_experience" => "Actual Experience", "skills_possesed" => "Skills Possessed", "remarks" => "Remarks"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "experience_required" => "Experience Required", "skills_required" => "Skills Required", "actual_education" => "Actual Education", "actual_experience" => "Actual Experience", "skills_possesed" => "Skills Possessed", "remarks" => "Remarks"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
<?php echo $this->Js->writeBuffer(); ?>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>