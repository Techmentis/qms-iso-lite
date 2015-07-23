<div id="competencyMappings_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="competencyMappings form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Competency Mapping'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($competencyMapping['CompetencyMapping']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($competencyMapping['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $competencyMapping['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Education'); ?></td>
                    <td>
                        <?php echo $this->Html->link($competencyMapping['Education']['title'], array('controller' => 'educations', 'action' => 'view', $competencyMapping['Education']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Experience Required'); ?></td>
                    <td>
                        <?php echo h($competencyMapping['CompetencyMapping']['experience_required']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Skills Required'); ?></td>
                    <td>
                        <?php echo h($competencyMapping['CompetencyMapping']['skills_required']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Actual Education'); ?></td>
                    <td>
                        <?php echo h($competencyMapping['ActualEducation']['title']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Actual Experience'); ?></td>
                    <td>
                        <?php echo h($competencyMapping['CompetencyMapping']['actual_experience']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Skills Possessed'); ?></td>
                    <td>
                        <?php echo h($competencyMapping['CompetencyMapping']['skills_possesed']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Remarks'); ?></td>
                    <td>
                        <?php echo h($competencyMapping['CompetencyMapping']['remarks']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($competencyMapping['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($competencyMapping['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($competencyMapping['CompetencyMapping']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $competencyMapping['CompetencyMapping']['created_by'], 'recordId' => $competencyMapping['CompetencyMapping']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#competencyMappings_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $competencyMapping['CompetencyMapping']['id'], 'ajax'), array('async' => true, 'update' => '#competencyMappings_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#competencyMappings_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>
