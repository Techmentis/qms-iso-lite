<?php if ($customerComplaints) { ?>
    <script>$('#cc-busy-indicator').hide()</script>
    <div id="cc" style="padding:10px;">

                <h3 class="panel-title">
                    <?php echo __("Customer Complaints assigned to you"); ?>
                    <?php echo $this->Html->link($totalComplaints, '#totalComplaints', array('id' => 'totalComplaints', 'class' => 'badge btn-danger', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('Total Customer Complaints assigned to you'))); ?><script>$('#totalComplaints').tooltip();</script>
                </h3>

                <table class="table table-condensed">
                    <tr>
                        <th><?php echo __("Customer"); ?></th>
                        <th><?php echo __("Complaint Number"); ?></th>
                        <th><?php echo __("Complaint Date"); ?></th>
                        <th><?php echo __("Complaint Source"); ?></th>
                        <th><?php echo __("Details"); ?></th>
                        <th class="col-md-1"><?php echo __("Target"); ?></th>
                        <th class="col-md-1"><?php echo __("Act"); ?></th>
                    </tr>

                    <?php foreach ($customerComplaints as $customerComplaint): ?>
                    <tr>
                        <td>
                            <?php if ($customerComplaint['added_in_meeting'] == 1) { ?>
                                <?php echo $this->Html->link('', '#', array('class' => 'glyphicon glyphicon-ok-sign text-succeess', 'data-placement' => 'top', 'data-toggle' => 'tooltip', 'title' => __('Added in meeting'))); ?><script>$('.glyphicon').tooltip();</script>
                            <?php } ?>
                            <?php echo $this->Html->link($customerComplaint['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $customerComplaint['Customer']['id'])); ?>
                        </td>
                        <td><?php echo h($customerComplaint['CustomerComplaint']['complaint_number']); ?>&nbsp;</td>
                        <td><?php echo h($customerComplaint['CustomerComplaint']['complaint_date']); ?>&nbsp;</td>
                        <td>
                            <?php
                                if ($customerComplaint['CustomerComplaint']['complaint_source'] == 0) {
                                    echo h($customerComplaint['Product']['name']);
                                } elseif ($customerComplaint['CustomerComplaint']['complaint_source'] == 1) {
                                    echo "Service";
                                } elseif ($customerComplaint['CustomerComplaint']['complaint_source'] == 2) {
                                    echo h($customerComplaint['DeliveryChallan']['challan_number']);
                                } else {
                                    echo "Customer Care";
                                }
                            ?>&nbsp;
                        </td>
                        <td><?php echo h($customerComplaint['CustomerComplaint']['details']); ?>&nbsp;</td>
                        <td><?php echo h($this->Time->timeAgoInWords($customerComplaint['CustomerComplaint']['target_date'], array('format' => 'F jS, Y'))); ?>&nbsp;</td>
                        <td>
                           
                            <?php echo $this->Html->link(__('Act'), array('controller' => 'customer_complaints', 'action' => 'edit', $customerComplaint['CustomerComplaint']['id']), array('class' => 'badge btn-danger')); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <?php
                    echo $this->Paginator->options(array(
                        'update' => '#cc',
                        'evalScripts' => true,
                        'before' => $this->Js->get('#cc-busy-indicator')->effect('fadeIn', array('buffer' => false)),
                        'complete' => $this->Js->get('#cc-busy-indicator')->effect('fadeOut', array('buffer' => false)),
                    ));
                ?>
                <ul class="pagination no-margin ">
                    <?php
                        echo "<li class='previous'>" . $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) . "</li>";
                        echo "<li>" . $this->Paginator->numbers(array('separator' => '')) . "</li>";
                        echo "<li class='next'>" . $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')) . "</li>";
                    ?>
                </ul>

    </div>
    <?php echo $this->Js->writeBuffer(); ?>
<?php } else{ ?>
    <div id="caps_stauts" style="padding:10px">

          <h3 class="panel-title"><?php echo  __("Customer Complaints assigned to you"); ?>
            <?php echo $this->Html->link($totalComplaints, '#totalComplaints', array('id' => 'totalComplaints', 'class' => 'badge btn-danger', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('Total Customer Complaints assigned to you'))); ?><script>$('#totalComplaints').tooltip();</script>
          </h3>
                    <hr/>
   No data Found

    </div>
   <?php
} ?>