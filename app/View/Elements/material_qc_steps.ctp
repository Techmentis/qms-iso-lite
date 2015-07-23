<?php if ($qcStepsPending) { ?>
    <script>$('#material-qc-busy-indicator').hide()</script>
    <div id="material_qc_steps" style="padding:10px;">

                <h3 class="panel-title"><?php echo __('Add QC Steps for Materials'); ?>
                    <span class='badge btn-danger'><?php echo $qcStepsCount; ?></span>
                </h3>
           <hr/>
                <table class="table table-condensed">
                    <tr>
                        <th><?php echo __("Material"); ?></th>

                        <th class="col-md-1"><?php echo __("Act"); ?></th>
                    </tr>
                    <?php foreach ($qcStepsPending as $material): ?>
                    <tr>
                        <td><?php echo $this->Html->link($material['Material']['name'], array('controller' => 'materials', 'action' => 'view', $material['Material']['id'])); ?></td>
                        <td><?php
                            echo $this->Html->link(__('Act'), array('controller' => 'material_quality_checks', 'action' => 'lists', $material['Material']['id']), array('class' => 'badge btn-warning'));
                            ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <?php
                    echo $this->Paginator->options(array(
                        'update' => '#material_qc_steps',
                        'evalScripts' => true,
                        'before' => $this->Js->get('#material-qc-busy-indicator')->effect('fadeIn', array('buffer' => false)),
                        'complete' => $this->Js->get('#material-qc-busy-indicator')->effect('fadeOut', array('buffer' => false)),
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
    <div id="material-qc" style="padding:10px;">

          <h3 class="panel-title"><?php echo __('Add QC Steps for Materials'); ?></h3>
                    <hr/>
   No data Found

    </div>
   <?php
} ?>