<?php if(count($assigned)){ ?>
<script>$('#capa-busy-indicator').hide()</script>
<div id="capa" style="padding:10px;">
 
       <h3 class="panel-title" ><?php echo __("Non Conformity Actions Required"); ?>
                <?php echo $this->Html->link($openCapa + $closeCapa, '#caps_stauts', array('id' => 'TotelCapa', 'class' => 'badge btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('Total Number of CAPAs assigned to you'))); ?><script>$('#TotelCapa').tooltip();</script>
                <?php echo $this->Html->link($openCapa, '#caps_stauts', array('id' => 'openCapa', 'class' => 'badge btn-danger', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('Total Number of CAPAs open'))); ?><script>$('#openCapa').tooltip();</script>
                <?php echo $this->Html->link($closeCapa, '#caps_stauts', array('id' => 'CloseCapa', 'class' => 'badge btn-success', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('Total Number of CAPAs closed'))); ?><script>$('#CloseCapa').tooltip();</script>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'capa-busy-indicator', 'class' => 'pull-right')); ?>

      </h3>
       
            <table class="table table-condensed">
                <tr>
                    <th><?php echo __("Number"); ?></th>
                    <th><?php echo __("Source"); ?></th>
                    <th><?php echo __("Category"); ?></th>
                    <th><?php echo __("Details"); ?></th>
                    <th><?php echo __("Initial Remarks"); ?></th>
                    <th class="col-md-1"><?php echo __("Target"); ?></th>
                    <th class="col-md-1"><?php echo __("Act"); ?></th>
                </tr>

                <?php if(isset($assigned))foreach ($assigned as $assign): ?>
                    <?php
                        if ($assign['CorrectivePreventiveAction']['target_date'] < date('Y-m-d'))
                            echo "<tr class='text-danger '>";
                        else
                            echo "<tr class='text-success'>";
                    ?>
                    <td>
                        <?php if ($assign['added_in_meeting'] == 1) {
                                echo $this->Html->link('', '#', array('class' => 'glyphicon glyphicon-ok-sign text-succeess', 'data-placement' => 'top', 'data-toggle' => 'tooltip', 'title' => __('Added in meeting'))); ?>
                                <script>$('.glyphicon').tooltip();</script>
                        <?php }
                                if ($assign['CorrectivePreventiveAction']['number'] == null)
                                    echo "00";
                                else
                                    echo $assign['CorrectivePreventiveAction']['number'];
                        ?>
                    </td>
                    <td><?php echo $assign['CapaSource']['name']; ?></td>
                    <td><?php echo $assign['CapaCategory']['name']; ?></td>
                    <td>
                    <?php
                        if ((isset($assign['InternalAudit']['clauses'])) && (!empty($assign['InternalAudit']['clauses'])))
                            echo 'Clauses:' . $assign['InternalAudit']['clauses'];
                        echo $assign['SuggestionForm']['suggestion'];
                        echo $assign['CustomerComplaint']['details'];
                        echo $assign['SupplierRegistration']['title'];
                        echo $assign['Product']['name'];
                        echo $assign['Device']['name'];
                        echo $assign['Material']['name'];
                    ?>
                    </td>
                    <td><?php echo $assign['CorrectivePreventiveAction']['initial_remarks']; ?></td>
                    <td><?php echo $this->Time->timeAgoInWords($assign['CorrectivePreventiveAction']['target_date'], array('format' => 'F jS, Y')); ?></td>
                    <td>
                        <?php
                            if ($assign['CorrectivePreventiveAction']['target_date'] > date('Y-m-d'))
                                echo $this->Html->link(__('Act'), array('controller' => 'corrective_preventive_actions', 'action' => 'edit', $assign['CorrectivePreventiveAction']['id']), array('class' => 'badge btn-warning'));
                            else
                                echo $this->Html->link(__('Act'), array('controller' => 'corrective_preventive_actions', 'action' => 'edit', $assign['CorrectivePreventiveAction']['id']), array('class' => 'badge btn-danger'));
                        ?>
                    </td>
<?php endforeach ?>
            </table>
      

            <?php
                echo $this->Paginator->options(array(
                    'update' => '#capa',
                    'evalScripts' => true,
                    'before' => $this->Js->get('#capa-busy-indicator')->effect('fadeIn', array('buffer' => false)),
                    'complete' => $this->Js->get('#capa-busy-indicator')->effect('fadeOut', array('buffer' => false)),
                ));
            ?>
            <ul class="pagination no-margin ">
                <?php
                    echo "<li class='previous'>" . $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) . "</li>";
                    echo "<li>" . $this->Paginator->numbers(array('separator' => '')) . "</li>";
                    echo "<li class='next'>" . $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')) . "</li>";
                ?>
            </ul>
       
   
    <?php echo $this->Js->writeBuffer(); ?>
<?php }else{ ?>
    <div id="capa" style="padding:10px">
          
        <h3 class="panel-title"><?php echo __("Non Conformity Actions Required"); ?></h3>
                    <hr/>
   No data Found

    </div>
   <?php
} ?>