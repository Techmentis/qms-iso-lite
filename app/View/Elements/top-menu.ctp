<div id="flinkiso_help_div"></div>
<div class="" id="top-menus">
    <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"></button>
            <?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'dashboard'), array('class' => 'navbar-brand')); ?>
        </div>

        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('DATA ENTRY'); ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo $this->Html->link(__('Branches'), array('controller' => 'branches', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link(__('Departments'), array('controller' => 'departments', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link(__('Designations'), array('controller' => 'designations', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link(__('Users'), array('controller' => 'users', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link(__('Products'), array('controller' => 'products', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link(__('Devices'), array('controller' => 'devices', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link(__('Customers'), array('controller' => 'customers', 'action' => 'index')); ?></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('DEPARTMENTS'); ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo $this->Html->link(__('Management Representative'), array('controller' => 'dashboards', 'action' => 'mr')); ?></li>
                        <li><?php echo $this->Html->link(__('Human Resource'), array('controller' => 'dashboards', 'action' => 'hr')); ?></li>
                        <li><?php echo $this->Html->link(__('Business Development') . '<small class="text-small text-muted"> beta</small>', array('controller' => 'dashboards', 'action' => 'bd'),array('escape'=>false)); ?></li>
                        <li><?php echo $this->Html->link(__('Administration'), array('controller' => 'dashboards', 'action' => 'personal_admin')); ?></li>
                        <li><?php echo $this->Html->link(__('Quality Control'), array('controller' => 'dashboards', 'action' => 'quality_control')); ?></li>
                        <li><?php echo $this->Html->link(__('Purchase'), array('controller' => 'dashboards', 'action' => 'purchase')); ?></li>
                        <li><?php echo $this->Html->link(__('Electronic Data Processing'), array('controller' => 'dashboards', 'action' => 'edp')); ?></li>
                        <li><?php echo $this->Html->link(__('Production') . '<small class="text-small text-muted"> beta</small>', array('controller' => 'dashboards', 'action' => 'production'),array('escape'=>false)); ?></li>
                    </ul>
                </li>
                <?php if($this->Session->read('User.is_mr') == 1 or $this->Session->read('User.is_mr') == true) {?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('REPORTS'); ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo $this->Html->link(__('AUTO REPORTS'), array('controller' => 'reports', 'action' => 'report_center')); ?></li>
                        <li><?php echo $this->Html->link(__('MANUAL REPORTS'), array('controller' => 'reports', 'action' => 'manual_reports')); ?></li>
                        <li><?php echo $this->Html->link(__('SAVED REPORTS'), array('controller' => 'reports', 'action' => 'saved_reports')); ?></li>
                        <li><?php echo $this->Html->link(__('SEARCH DOCUMENTS'), array('controller' => 'file_uploads', 'action' => 'file_advanced_search')); ?></li>
                    </ul>
                </li>
		<li>
		    <?php echo $this->Html->link(__('UPGRADE'), array('controller' => 'users','action'=>'upgrade')); ?>
		</li>
                <?php }?>
            </ul>
            <ul class="nav navbar-nav navbar-right top-icons">
                <li class="dropdown"><?php echo $this->Html->link('', array('controller' => 'helps', 'action' => 'help'), array('id' => 'flinkiso_help', 'class' => 'glyphicon glyphicon-book nav-bar-title', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('FlinkISO Help'))); ?><script>$('.glyphicon').tooltip();</script>
                    <ul class="dropdown-menu">
                        <li><?php echo $this->Html->link(__('Suppliers'), array('controller' => 'list_of_acceptable_suppliers', 'action' => 'lists')); ?></li>
                        <li><?php echo $this->Html->link(__('Supplier Registrations'), array('controller' => 'supplier_registrations', 'action' => 'lists')); ?></li>
                        <li><?php echo $this->Html->link(__('Supplier Evaluation'), array('controller' => 'supplier_evaluation_reevaluations', 'action' => 'lists')); ?></li>
                    </ul>
                </li>

                <li>
                    <?php echo $this->Html->link('', array('controller' => 'notifications', 'action' => 'index'), array('class' => 'glyphicon glyphicon-bell nav-bar-title', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('Notifications'))); ?>
                    <script>$('.glyphicon').tooltip();</script>
                    <?php
                        if (isset($notificationCount) && $notificationCount > 0)
                            echo "<span class='notification_count badge btn-danger'>" . $notificationCount . "</span>";
                    ?>
                </li>

                <li><?php echo $this->Html->link('', array('controller' => 'suggestion_forms', 'action' => 'index'), array('class' => 'glyphicon glyphicon-flash nav-bar-title', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('Suggestion Form'))); ?><script>$('.glyphicon').tooltip();</script>
                    <?php
                        if (isset($suggestionCount) && $suggestionCount > 0)
                            echo "<span class='notification_count badge btn-danger'>" . $suggestionCount . "</span>";
                    ?>
                </li>
                <!--<li style="display: none"><?php echo $this->Html->link('', '#', array('class' => 'glyphicon glyphicon-plus nav-bar-title', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('Add this action to your dashboard'))); ?><script>$('.glyphicon').tooltip();</script></li>-->

                <li  class="dropdown">
                    <?php
                        echo $this->Html->link('', '#', array('class' => 'glyphicon glyphicon-globe nav-bar-title dropdown-toggle', 'data-toggle' => 'dropdown', 'data-placement' => 'bottom', 'title' => __('Change your language for this session')));
                        $languages = $this->requestAction('App/language_details');
                    ?>
                    <ul class="dropdown-menu">
                        <?php foreach ($languages as $language) { ?>
                            <li><?php echo $this->Html->link(__($language['Language']['name']), array('controller' => 'languages', 'action' => 'change_language', $language['Language']['short_code'])); ?></li>

                        <?php }
		     ?>
                    </ul>
                </li>

                <li><?php echo $this->Html->link('', array('controller' => 'messages', 'action' => 'index'), array('class' => 'glyphicon glyphicon-send nav-bar-title', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('Send messages'))); ?><script>$('.glyphicon').tooltip();</script>
                    <?php
                        if (isset($messageCount) && $messageCount > 0)
                            echo "<span class='notification_count badge btn-danger'>" . $messageCount . "</span>";
                    ?>
                </li>
               <li><?php echo $this->Html->link('', array('controller' => 'users', 'action' => 'smtp_details'), array('class' => 'glyphicon glyphicon-transfer nav-bar-title', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('SMTP Setup'))); ?><script>$('.glyphicon').tooltip();</script></li>
                <li><?php echo $this->Html->link('', array('controller' => 'companies', 'action' => 'view', $companyDetails['Company']['id']), array('class' => 'glyphicon glyphicon-cog nav-bar-title', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('Company Profile'))); ?><script>$('.glyphicon').tooltip();</script></li>
            </ul>
        </div>
    </div>
</div>

