<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="usernamePasswordDetails ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Username Password Details', 'modelClass' => 'UsernamePasswordDetail', 'options' => array("sr_no" => "Sr No", "username" => "Username", "password" => "Password", "date_of_change" => "Date Of Change"), 'pluralVar' => 'usernamePasswordDetails'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Username Password Detail'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="usernamePasswordDetails_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "username" => "Username", "password" => "Password", "date_of_change" => "Date Of Change"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "username" => "Username", "password" => "Password", "date_of_change" => "Date Of Change"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>