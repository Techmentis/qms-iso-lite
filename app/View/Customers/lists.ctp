<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="customers ">
    <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Customers', 'modelClass' => 'Customer', 'options' => array("sr_no" => "Sr No", "name" => "Name", "customer_code" => "Customer Code", "customer_since_date" => "Customer Since Date", "date_of_birth" => "Date Of Birth", "phone" => "Phone", "mobile" => "Mobile", "email" => "Email", "age" => "Age", "residence_address" => "Residence Address", "maritial_status" => "Marital Status"), 'pluralVar' => 'customers'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Customer'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="customers_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("name" => "Name", "customer_code" => "Customer Code", "customer_since_date" => "Customer Since Date", "date_of_birth" => "Date Of Birth", "phone" => "Phone", "mobile" => "Mobile", "email" => "Email", "age" => "Age", "residence_address" => "Residence Address", "maritial_status" => "Marital Status"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "customer_code" => "Customer Code", "customer_since_date" => "Customer Since Date", "date_of_birth" => "Date Of Birth", "phone" => "Phone", "mobile" => "Mobile", "email" => "Email", "age" => "Age", "residence_address" => "Residence Address", "maritial_status" => "Marital Status"))); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>