
<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="users ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Users', 'modelClass' => 'User', 'options' => array("sr_no" => "Sr No", "name" => "Name", "username" => "Username", "is_mr" => "Is Mr", "is_view_all" => "Is View All", "is_approvar" => "Is Approvar", "status" => "Status", "login_status" => "Login Status", "last_login" => "Last Login", "last_activity" => "Last Activity", "user_access" => "User Access", "email_token_expires" => "Email Token Expires"), 'pluralVar' => 'users'))); ?>

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
                    <th><?php echo $this->Paginator->sort('employee_id', __('Employee')); ?></th>
                    <th><?php echo $this->Paginator->sort('username', __('Username')); ?></th>
                    <th><?php echo $this->Paginator->sort('is_mr', __('is MR?')); ?></th>
                    <th><?php echo $this->Paginator->sort('is_view_all', __('is View All?')); ?></th>
                    <th><?php echo $this->Paginator->sort('is_approvar', __('is Approver?')); ?></th>
                    <th><?php echo $this->Paginator->sort('department_id', __('Department')); ?></th>
                    <th><?php echo $this->Paginator->sort('branch_id', __('Branch')); ?></th>
                    <th><?php echo $this->Paginator->sort('language_id', __('Language')); ?></th>
                    <th><?php echo $this->Paginator->sort('benchmark', __('Benchmark')); ?></th>
                    <th><?php echo $this->Paginator->sort('last_login', __('Last Login')); ?></th>
                    <th><?php echo $this->Paginator->sort('last_activity', __('Last Activity')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php if ($users) {
                        $x = 0;
                        foreach ($users as $user):
                ?>
                <tr>

                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $user['User']['created_by'], 'postVal' => $user['User']['id'], 'softDelete' => $user['User']['soft_delete'])); ?></td>
                    <td><?php echo $user['User']['name']; ?>&nbsp;</td>
                    <td><?php echo $user['User']['username']; ?>&nbsp;</td>
                    <td><?php echo $user['User']['is_mr'] ? __('Yes') : __('No'); ?>&nbsp;</td>
                    <td><?php echo $user['User']['is_view_all'] ? __('Yes') : __('No'); ?>&nbsp;</td>
                    <td><?php echo $user['User']['is_approvar'] ? __('Yes') : __('No') ?>&nbsp;</td>

                    <td>
                        <?php echo $this->Html->link($user['Department']['name'], array('controller' => 'departments', 'action' => 'view', $user['Department']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($user['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $user['Branch']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($user['Language']['name'], array('controller' => 'languages', 'action' => 'view', $user['Language']['id'])); ?>
                    </td>
                    <td><?php echo $user['User']['benchmark']; ?>&nbsp;</td>
                    <td><?php echo $user['User']['last_login']; ?>&nbsp;</td>
                    <td><?php echo $user['User']['last_activity']; ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$user['User']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$user['User']['approved_by']]); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($user['User']['publish'] == 1) { ?>
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
                <tr><td colspan=29><?php echo __('No results found'); ?></td></tr>
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
            ?></p>
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
<?php echo $this->element('advanced-search', array('postData' => array("name" => "Name", "username" => "Username", "is_mr" => "Is Mr", "is_view_all" => "Is View All", "is_approvar" => "Is Approvar", "status" => "Status", "login_status" => "Login Status", "last_login" => "Last Login", "last_activity" => "Last Activity", "user_access" => "User Access", "email_token_expires" => "Email Token Expires"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "username" => "Username", "is_mr" => "Is Mr", "is_view_all" => "Is View All", "is_approvar" => "Is Approvar", "status" => "Status", "login_status" => "Login Status", "last_login" => "Last Login", "last_activity" => "Last Activity", "user_access" => "User Access", "email_token_expires" => "Email Token Expires"))); ?>
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