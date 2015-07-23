<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="internalAuditPlans ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Internal Audit Plans', 'modelClass' => 'InternalAuditPlan', 'options' => array("sr_no" => "Sr No", "title" => "Title", "audit_date" => "Audit Date", "clauses" => "Clauses", "audit_from" => "Audit From", "audit_to" => "Audit To", "note" => "Note"), 'pluralVar' => 'internalAuditPlans'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php 
                    if(isset($this->request->params['pass'][0]))
                        echo $this->Html->link(__('Create schedule'), array('action' => 'plan_add_ajax', $this->request->params['pass'][0] ));
                    else
                        echo $this->Html->link(__('Create schedule'), array('action' => 'plan_add_ajax' ));
                    ?>
                    
                    </li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="internalAuditPlans_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "audit_date" => "Audit Date", "clauses" => "Clauses", "audit_from" => "Audit From", "audit_to" => "Audit To", "note" => "Note"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import'); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>