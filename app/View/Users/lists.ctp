<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="users ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Users', 'modelClass' => 'User', 'options' => array("sr_no" => "Sr No", "name" => "Name", "username" => "Username", "password" => "Password", "is_mr" => "Is Mr", "is_view_all" => "Is View All", "is_approvar" => "Is Approvar", "status" => "Status", "login_status" => "Login Status", "last_login" => "Last Login", "last_activity" => "Last Activity", "user_access" => "User Access", "password_token" => "Password Token", "email_token_expires" => "Email Token Expires"), 'pluralVar' => 'users'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New User'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->link(__('New Employee'), array('controller' => 'employees', 'action' => 'add_ajax')); ?></li>
                </ul>
            </div>
        </div>
        <div id="users_tab_ajax"></div>
    </div>

<script>
    $(function() {
        $("#tabs").tabs({
            beforeLoad: function(event, ui) {
                ui.jqXHR.error(function() {
                    ui.panel.html(
                            "Error Loading ... " +
                            "Please contact administrator.");
                });
            }
        });
    });
</script>

    <?php echo $this->element('export'); ?>
    <?php echo $this->element('advanced-search', array('postData' => array("name" => "Name", "username" => "Username", "password" => "Password", "is_mr" => "Is Mr", "is_view_all" => "Is View All", "is_approvar" => "Is Approvar", "status" => "Status", "login_status" => "Login Status", "last_login" => "Last Login", "last_activity" => "Last Activity", "user_access" => "User Access", "password_token" => "Password Token", "email_token_expires" => "Email Token Expires"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "username" => "Username", "password" => "Password", "is_mr" => "Is Mr", "is_view_all" => "Is View All", "is_approvar" => "Is Approvar", "status" => "Status", "login_status" => "Login Status", "last_login" => "Last Login", "last_activity" => "Last Activity", "user_access" => "User Access", "password_token" => "Password Token", "email_token_expires" => "Email Token Expires"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>