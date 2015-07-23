<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="customers ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Customers', 'modelClass' => 'Customer', 'options' => array("sr_no" => "Sr No", "name" => "Name", "customer_code" => "Customer Code", "customer_since_date" => "Customer Since Date", "date_of_birth" => "Date Of Birth", "phone" => "Phone", "mobile" => "Mobile", "email" => "Email", "age" => "Age", "residence_address" => "Residence Address", "maritial_status" => "Marital Status"), 'pluralVar' => 'customers'))); ?>

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
                    <th><?php echo $this->Paginator->sort('customer_type'); ?></th>
                    <th><?php echo $this->Paginator->sort('name'); ?></th>
                    <th><?php echo $this->Paginator->sort('customer_since_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('customer_code'); ?></th>
                    <th><?php echo $this->Paginator->sort('email'); ?></th>
                    <th><?php echo $this->Paginator->sort('phone'); ?></th>
                    <th><?php echo $this->Paginator->sort('mobile'); ?></th>
                    <th><?php echo $this->Paginator->sort('branch_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish'); ?></th>
                </tr>
                <?php
                    if ($customers) {
                        $x = 0;
                        foreach ($customers as $customer):
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $customer['Customer']['created_by'], 'postVal' => $customer['Customer']['id'], 'softDelete' => $customer['Customer']['soft_delete'])); ?>
                    </td>
                    <td><?php echo $customer['Customer']['customer_type'] ? 'Individual' : 'Company'; ?>&nbsp;</td>
                    <td><?php echo h($customer['Customer']['name']); ?>&nbsp;</td>
                    <td><?php echo h($customer['Customer']['customer_since_date']); ?>&nbsp;</td>
                    <td><?php echo h($customer['Customer']['customer_code']); ?>&nbsp;</td>
                    <td><a href="mailto:<?php echo h($customer['Customer']['email']); ?>"><?php echo h($customer['Customer']['email']); ?></a>&nbsp;</td>
                    <td><?php echo h($customer['Customer']['phone']); ?>&nbsp;</td>
                    <td><?php echo h($customer['Customer']['mobile']); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($customer['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $customer['Branch']['id'])); ?>
                    </td>
                    <td><?php echo h($PublishedEmployeeList[$customer['Customer']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$customer['Customer']['approved_by']]); ?>&nbsp;</td>

                    <td width="60">
                        <?php if ($customer['Customer']['publish'] == 1) { ?>
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
                <tr><td colspan=23>No results found</td></tr>
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
<?php echo $this->element('common'); ?>
<?php echo $this->element('advanced-search', array('postData' => array("name" => "Name", "customer_code" => "Customer Code", "customer_since_date" => "Customer Since Date", "date_of_birth" => "Date Of Birth", "phone" => "Phone", "mobile" => "Mobile", "email" => "Email", "age" => "Age", "residence_address" => "Residence Address", "maritial_status" => "Marital Status"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "customer_code" => "Customer Code", "customer_since_date" => "Customer Since Date", "date_of_birth" => "Date Of Birth", "phone" => "Phone", "mobile" => "Mobile", "email" => "Email", "age" => "Age", "residence_address" => "Residence Address", "maritial_status" => "Marital Status"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->Js->writeBuffer(); ?>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>