<style>
    input[type="checkbox"]{margin-bottom:3px; margin-top :2px !important}
</style>
<div style="width:125px">
    <div class="btn-group" >
        <?php if (($this->request->params['controller'] == 'customer_meetings') || ($this->request->params['controller'] == 'proposals')|| ($this->request->params['controller'] == 'proposal_followups')) {
            if ($created == $this->Session->read('User.id') || ($this->Session->read('User.is_mr') == true)) {
                ?>
                <span class="btn  btn-sm btn-default ">
                <?php echo $this->Form->checkbox('rec_ids', array('label' => false, 'div' => false, 'value' => $postVal, 'multiple' => 'checkbox', 'class' => 'rec_ids', 'onClick' => 'getVals()')); ?>       </span>
            <?php } else { ?>
                <button type="button" class="btn  btn-sm btn-default ">&nbsp;<span class=" glyphicon glyphicon-lock"></span></button>
                <?php }
            } else { ?>
            <span class="btn  btn-sm btn-default ">
            <?php echo $this->Form->checkbox('rec_ids_', array('label' => false, 'div' => false, 'value' => $postVal, 'multiple' => 'checkbox', 'class' => 'rec_ids', 'onClick' => 'getVals()')); ?>       </span> <?php } ?>
        <button type="button" data-toggle="dropdown" class="btn  btn-sm btn-default ">&nbsp;<span class=" glyphicon glyphicon-wrench"></span></button>

        <?php if (($this->request->params['controller'] == 'customer_meetings') || ($this->request->params['controller'] == 'proposals')|| ($this->request->params['controller'] == 'proposals')|| ($this->request->params['controller'] == 'proposal_followups')) {

            if ($created == $this->Session->read('User.id') || ($this->Session->read('User.is_mr') == true)) {
                ?>
                <ul class="dropdown-menu" role="menu">
                    <li>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $postVal), array('style' => 'display:none'), __('Are you sure you want to delete this record ?', $postVal)); ?>
                    </li>
        <?php if (isset($this->params['named'])) {
            if (isset($softDelete) && $softDelete == 1) {
                ?>
                            <li><?php echo $this->Form->postLink(__('Restore'), array('action' => 'restore', $postVal)); ?></li>
                            <li><?php echo $this->Form->postLink(__('Purge'), array('action' => 'purge', $postVal)); ?></li>

                        <?php } else { ?>

                            <li><?php echo $this->Html->link(__('View / Upload Evidence'), array('action' => 'view', $postVal)); ?></li>
                            <li><?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $postVal)); ?> <?php echo $this->Html->link(__('Edit in new window'), array('action' => 'edit', $postVal), array('target' => '_blank')); ?></li>
                            <?php if ($this->Session->read('User.is_mr') == true) ; ?><li><?php echo $this->Html->link(__('Publish Record'), array('action' => 'publish_record', $postVal), null, __('Are you sure you want to publish this record ?', $postVal)); ?></li>

                            <li>
                        <?php echo $this->Form->postLink(__('Delete Record'), array('action' => 'delete', $postVal), array('class' => ''), __('Are you sure ?', $postVal)); ?>
                            </li>
            <?php }
        }
        ?>
                </ul>
            <?php } else { ?>
                <ul class="dropdown-menu" role="menu">
                    <li><?php echo $this->Html->link(__('View / Upload Evidence'), array('action' => 'view', $postVal)); ?></li>
                </ul>
                <?php }?>

        <?php  }else { ?>
    <?php if ($this->request->params['controller'] == 'reports' || $this->request->params['controller'] == 'list_of_measuring_devices_for_calibrations' || ($this->request->params['controller'] =='stocks' && $this->request->params['pass'][0] == 1)) { ?>
                <ul class="dropdown-menu" role="menu">

                    <li>
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $postVal), array('style' => 'display:none'), __('Are you sure you want to delete this record ?', $postVal)); ?>
                    </li>
                    <?php if (isset($this->params['named'])) {
                        if (isset($softDelete) && $softDelete == 1) {
                            ?>
                            <li><?php echo $this->Form->postLink(__('Restore'), array('action' => 'restore', $postVal)); ?></li>
                            <li><?php echo $this->Form->postLink(__('Purge'), array('action' => 'purge', $postVal)); ?></li>

                        <?php } else { ?>
                            <li><?php echo $this->Html->link(__('View / Upload Evidence'), array('action' => 'view', $postVal)); ?></li>
                            <li><?php echo $this->Form->postLink(__('Delete Record'), array('action' => 'delete', $postVal), array('class' => ''), __('Are you sure ?', $postVal)); ?></li>

                        <?php }
                    } ?>
                </ul> <?php } else { ?>
                <ul class="dropdown-menu" role="menu">
                    <li>
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $postVal), array('style' => 'display:none'), __('Are you sure you want to delete this record ?', $postVal)); ?>
                    </li>
                    <?php if (isset($this->params['named'])) {
                        if (isset($softDelete) && $softDelete == 1) {
                            ?>
                            <li><?php echo $this->Form->postLink(__('Restore'), array('action' => 'restore', $postVal)); ?></li>
                            <li><?php echo $this->Form->postLink(__('Purge'), array('action' => 'purge', $postVal)); ?></li>

            <?php } else {
                ?>

                            <li><?php echo $this->Html->link(__('View / Upload Evidence'), array('action' => 'view', $postVal)); ?></li>
                            <li><?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $postVal)); ?> <?php echo $this->Html->link(__('Edit in new window'), array('action' => 'edit', $postVal), array('target' => '_blank')); ?></li>

                        <?php if ($this->Session->read('User.is_mr') == true) ; ?><li><?php echo $this->Html->link(__('Publish Record'), array('action' => 'publish_record', $postVal), null, __('Are you sure you want to publish this record ?', $postVal)); ?></li>

                            <li><?php echo $this->Form->postLink(__('Delete Record'), array('action' => 'delete', $postVal), array('class' => ''), __('Are you sure ?', $postVal)); ?></li>

                    <?php }
                }
                ?>
                </ul>

    <?php }
} ?>
<?php
$path = WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/upload/' . $created . '/' . $this->params->controller . '/' . $postVal . '/';
//else $path = $path = WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/upload/' . $created . '/' . $this->params->controller . '/' . $postVal ;
$dir = new Folder($path);
//$files = $dir->read(true);
$files = $dir->findRecursive('.*', false);

if (count($files) > 0) {
    ?>
            <button type="button" class="btn btn-sm btn-success" style="border-bottom-right-radius:3px; border-top-right-radius:3px; border-left:0px " id='<?php echo $postVal ?>-count' data-toggle='tooltip' data-original-title='<?php echo count($files) ?> Evidence Uploaded'>&nbsp;<?php echo count($files) ?></button>
<?php } else { ?>
            <button type="button" class="btn btn-sm btn-default" style="border-bottom-right-radius:3px; border-top-right-radius:3px; border-left:0px " id='<?php echo $postVal ?>-count' data-toggle='tooltip' data-original-title='0 Evidence Uploaded'>&nbsp;0</button>
<?php } ?>
        <script>$('#<?php echo $postVal ?>-count').tooltip();</script>
    </div>

</div>
<?php echo $this->Js->writeBuffer(); ?>