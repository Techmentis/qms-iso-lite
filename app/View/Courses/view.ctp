<div id="courses_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="courses form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Course'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo $course['Course']['sr_no']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Title'); ?></td>
                    <td>
                        <?php echo $course['Course']['title']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Course Type'); ?></td>
                    <td>
                        <?php echo $this->Html->link($course['CourseType']['title'], array('controller' => 'course_types', 'action' => 'view', $course['CourseType']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Description'); ?></td>
                    <td>
                        <?php echo $course['Course']['description']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo $course['PreparedBy']['name']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo $course['ApprovedBy']['name']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($course['Course']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $course['Course']['created_by'], 'recordId' => $course['Course']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#courses_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $course['Course']['id'], 'ajax'), array('async' => true, 'update' => '#courses_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#courses_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>
