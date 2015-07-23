<?php
    if ($unpublished == null)
        $unpublished = 0;
    if ($count == null)
        $count = 0;
    if ($published == null)
        $published = 0;
    if ($deleted == null)
        $deleted = 0;
?>
<?php
    unset($postData['options']['sr_no']);
    unset($postData['options']['user_access']);
    unset($postData['options']['soft_delete']);
    unset($postData['options']['publish']);
    unset($postData['options']['publish']);
?>
<?php if( isset($postData['action']) && $postData['action'] == 'add'){?>
<div class="row">
                <div class="col-md-8">
                    <h4><?php echo $this->element('breadcrumbs'); ?><?php echo h($postData["pluralHumanName"]); ?></h4>
                    <h4>
                        <?php if ($this->action != 'capa_advanced_search' && $this->action != 'search') { ?>
                            <?php echo '<span class="badge btn-info">' . $this->Html->link($count, '#', array('id' => 'count', 'class' => 'btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')) . '</span>'; ?><script>$('#count').tooltip();</script>
                            <?php echo '<span class="badge btn-success">' . $this->Html->link($published, '#', array('id' => 'published', 'class' => 'btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Published Records')) . '</span>'; ?><script>$('#published').tooltip();</script>
                            <?php echo '<span class="badge btn-warning">' . $this->Html->link($unpublished, '#', array('id' => 'unpublished', 'class' => 'btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Unpublished Records')) . '</span>'; ?><script>$('#unpublished').tooltip();</script>
                            <?php echo '<span class="badge btn-danger">' . $this->Html->link($deleted, '#', array('id' => 'deleted', 'class' => 'btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Deleted Records')) . '</span>'; ?><script>$('#deleted').tooltip();</script>
                        <?php } ?>
                        <span class=""></span>
                        <?php echo $this->Html->link(__('Add'), array('action' => 'lists'), array('id' => 'addrecord', 'class' => 'label btn-primary', 'data-original-title' => 'Add New Record')); ?>
                        <script>$('#addrecord').tooltip();</script>

                        <?php  echo $this->Html->link(__('Import/Export'), '#import', array('id' => 'imp', 'class' => 'label btn-info', 'data-toggle' => 'modal', 'data-original-title' => 'Import Records', 'onClick' => 'show_hide();'));?>
                        <script>$('#imp').tooltip();</script>

                        <?php echo $this->Html->link(__('Delete All'), '#deleteAll', array('class' => 'label btn-danger', 'data-toggle' => 'modal', 'onClick' => 'getVals()')); ?>
                        <span class=""></span>
                        <?php echo $this->Html->link('', array('action' => 'index'), array('id' => 'gridcall', 'class' => 'glyphicon glyphicon-list h4-title', 'data-original-title' => 'Switch to grid mode')); ?>
                        <script>$('#gridcall').tooltip();</script>
                    </h4>
                </div>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </div>
           <?php $this->Js->get('#addrecord');
                    $this->Js->event('click', $this->Js->request(array('action' => 'lists',NULL), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#gridcall');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#count');
                    if($postData['action'] == 'add'){
                    $this->Js->event('click', $this->Js->request(array('action' => 'index', 'capa_type' => $this->request->params['pass'][0]), array('async' => true, 'update' => '#main')));
                    }else{
                    $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'capa_type' => $this->request->params['pass'][0]), array('async' => true, 'update' => '#capa_main_inner')));}
                    $this->Js->get('#published');
                    if($postData['action'] == 'add'){
                    $this->Js->event('click', $this->Js->request(array('action' => 'index', 'capa_type' => $this->request->params['pass'][0]), array('async' => true, 'update' => '#main')));
                    }else{
                    $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'published' => 1, 'capa_type' => $this->request->params['pass'][0]), array('async' => true, 'update' => '#capa_main_inner')));
                    }
                    $this->Js->get('#unpublished');
                    if($postData['action'] == 'add'){
                    $this->Js->event('click', $this->Js->request(array('action' => 'index', 'capa_type' => $this->request->params['pass'][0]), array('async' => true, 'update' => '#main')));
                    }else{
                    $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'published' => 0, 'capa_type' => $this->request->params['pass'][0]), array('async' => true, 'update' => '#capa_main_inner')));
                    }
                    $this->Js->get('#deleted');
                    if($postData['action'] == 'add'){
                    $this->Js->event('click', $this->Js->request(array('action' => 'index', 'capa_type' => $this->request->params['pass'][0]), array('async' => true, 'update' => '#main')));
                    }else{
                    $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'soft_delete' => 1, 'capa_type' => $this->request->params['pass'][0]), array('async' => true, 'update' => '#capa_main_inner')));
                    }?>
<?php }else{?>
<?php if (isset($this->params['named'])) {
        if (isset($this->params['named']['soft_delete'])) {?>
            <div class="nav">
                <div class="col-md-8">
                    <h4><?php echo $this->element('breadcrumbs'); ?><?php echo h($postData["pluralHumanName"]); ?></h4>
                    <h4>
                        <?php if ($this->action != 'capa_advanced_search' && $this->action != 'search') { ?>
                            <?php echo '<span class="badge btn-info">' . $this->Html->link($count, '#', array('id' => 'count', 'class' => 'btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')) . '</span>'; ?><script>$('#count').tooltip();</script>
                            <?php echo '<span class="badge btn-success">' . $this->Html->link($published, '#', array('id' => 'published', 'class' => 'btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Published Records')) . '</span>'; ?><script>$('#published').tooltip();</script>
                            <?php echo '<span class="badge btn-warning">' . $this->Html->link($unpublished, '#', array('id' => 'unpublished', 'class' => 'btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Unpublished Records')) . '</span>'; ?><script>$('#unpublished').tooltip();</script>
                            <?php echo '<span class="badge btn-danger">' . $this->Html->link($deleted, '#', array('id' => 'deleted', 'class' => 'btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Deleted Records')) . '</span>'; ?><script>$('#deleted').tooltip();</script>
                        <?php }
                            $this->Js->get('#addrecord');
                            $this->Js->event('click', $this->Js->request(array('action' => 'lists', 'capa_type' => null), array('async' => true, 'update' => '#main')));
                            $this->Js->get('#gridcall');
                            if (isset($this->request->params['named']['published']))
                                $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'capa_type' => $this->request->params['named']['capa_type']), array('async' => true, 'update' => '#capa_main_inner')));

                                else$this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                            $this->Js->get('#count');
                            $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'capa_type' => $this->request->params['named']['capa_type']), array('async' => true, 'update' => '#capa_main_inner')));
                            $this->Js->get('#published');
                            $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'published' => 1, 'capa_type' => $this->request->params['named']['capa_type']), array('async' => true, 'update' => '#capa_main_inner')));
                            $this->Js->get('#unpublished');
                            $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'published' => 0, 'capa_type' => $this->request->params['named']['capa_type']), array('async' => true, 'update' => '#capa_main_inner')));
                            $this->Js->get('#deleted');
                            $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'soft_delete' => 1, 'capa_type' => $this->request->params['named']['capa_type']), array('async' => true, 'update' => '#capa_main_inner')));
                            echo $this->Js->writeBuffer();
                        ?>
                        <span class=""></span>
                        <?php echo $this->Html->link(__('Restore All'), '#restoreAll', array('class' => 'label btn-success', 'data-toggle' => 'modal', 'onClick' => 'getVals()')); ?>
                        <?php echo $this->Html->link(__('Purge All'), '#purgeAll', array('class' => 'label btn-danger', 'data-toggle' => 'modal', 'onClick' => 'getVals()')); ?>
                        <span class=""></span>
                        <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
                    </h4>
                </div>
            </div>
        <?php }else {?>
            <div class="row">
                <div class="col-md-8">
                    <h4><?php echo $this->element('breadcrumbs'); ?><?php echo h($postData["pluralHumanName"]); ?></h4>
                    <h4>
                        <?php if ($this->action != 'capa_advanced_search' && $this->action != 'search') { ?>
                            <?php echo '<span class="badge btn-info">' . $this->Html->link($count, '#', array('id' => 'count', 'class' => 'btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')) . '</span>'; ?><script>$('#count').tooltip();</script>
                            <?php echo '<span class="badge btn-success">' . $this->Html->link($published, '#', array('id' => 'published', 'class' => 'btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Published Records')) . '</span>'; ?><script>$('#published').tooltip();</script>
                            <?php echo '<span class="badge btn-warning">' . $this->Html->link($unpublished, '#', array('id' => 'unpublished', 'class' => 'btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Unpublished Records')) . '</span>'; ?><script>$('#unpublished').tooltip();</script>
                            <?php echo '<span class="badge btn-danger">' . $this->Html->link($deleted, '#', array('id' => 'deleted', 'class' => 'btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Deleted Records')) . '</span>'; ?><script>$('#deleted').tooltip();</script>
                        <?php } ?>
                        <span class=""></span>
                        <?php echo $this->Html->link(__('Add'), array('action' => 'lists'), array('id' => 'addrecord', 'class' => 'label btn-primary', 'data-original-title' => 'Add New Record')); ?>
                        <script>$('#addrecord').tooltip();</script>

                        <?php  echo $this->Html->link(__('Import/Export'), '#import', array('id' => 'imp', 'class' => 'label btn-info', 'data-toggle' => 'modal', 'data-original-title' => 'Import Records', 'onClick' => 'show_hide();'));?>
                        <script>$('#imp').tooltip();</script>

                        <?php echo $this->Html->link(__('Delete All'), '#deleteAll', array('class' => 'label btn-danger', 'data-toggle' => 'modal', 'onClick' => 'getVals()')); ?>
                        <span class=""></span>
                        <?php echo $this->Html->link('', array('action' => 'index'), array('id' => 'gridcall', 'class' => 'glyphicon glyphicon-list h4-title', 'data-original-title' => 'Switch to grid mode')); ?>
                        <script>$('#gridcall').tooltip();</script>
                    </h4>
                </div>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </div>
            <?php
                if (!empty($this->request->params['named'])) {
                    $this->Js->get('#addrecord');
                    $this->Js->event('click', $this->Js->request(array('action' => 'lists',null), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#gridcall');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#count');
                    $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'capa_type' => $this->request->params['named']['capa_type']), array('async' => true, 'update' => '#capa_main_inner')));
                    $this->Js->get('#published');
                    $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'published' => 1, 'capa_type' => $this->request->params['named']['capa_type']), array('async' => true, 'update' => '#capa_main_inner')));
                    $this->Js->get('#unpublished');
                    $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'published' => 0, 'capa_type' => $this->request->params['named']['capa_type']), array('async' => true, 'update' => '#capa_main_inner')));
                    $this->Js->get('#deleted');
                    $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'soft_delete' => 1, 'capa_type' => $this->request->params['named']['capa_type']), array('async' => true, 'update' => '#capa_main_inner')));
                } else {
                    if($this->request['action'] == 'capa_status'){
                        $this->Js->get('#addrecord');
                    $this->Js->event('click', $this->Js->request(array('action' => 'lists',null), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#gridcall');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#count');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#published');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#unpublished');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#deleted');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    }
                    else if($this->request['action'] == 'get_ncs'){
                        $this->Js->get('#addrecord');
                    $this->Js->event('click', $this->Js->request(array('action' => 'lists',null), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#gridcall');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#count');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#published');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#unpublished');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#deleted');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    }
                    else{
                    $this->Js->get('#addrecord');
                    $this->Js->event('click', $this->Js->request(array('action' => 'lists',null), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#gridcall');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#count');
                    $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'capa_type' => $this->request->params['pass'][0]), array('async' => true, 'update' => '#capa_main_inner')));
                    $this->Js->get('#published');
                    $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'published' => 1, 'capa_type' => $this->request->params['pass'][0]), array('async' => true, 'update' => '#capa_main_inner')));
                    $this->Js->get('#unpublished');
                    $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'published' => 0, 'capa_type' => $this->request->params['pass'][0]), array('async' => true, 'update' => '#capa_main_inner')));
                    $this->Js->get('#deleted');
                    $this->Js->event('click', $this->Js->request(array('action' => 'get_capa_index', 'soft_delete' => 1, 'capa_type' => $this->request->params['pass'][0]), array('async' => true, 'update' => '#capa_main_inner')));
                    }
                }
                   echo $this->Js->writeBuffer();
        }
    }
}?>