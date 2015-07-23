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
?>
<?php
    if (isset($this->params['named'])) {
        if (isset($this->params['named']['soft_delete'])) {?>
            <div class="nav">
                <div class="col-md-8">
                    <h4><?php echo $this->element('breadcrumbs'); ?><?php echo h($postData["pluralHumanName"]); ?></h4>
                    <h4>
                        <?php if ($this->action != 'advanced_search' && $this->action != 'search') { ?>
                            <?php echo '<span class="badge btn-info">' . $this->Html->link($count, '#', array('id' => 'count', 'class' => 'btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')) . '</span>'; ?><script>$('#count').tooltip();</script>
                            <?php echo '<span class="badge btn-success">' . $this->Html->link($published, '#', array('id' => 'published', 'class' => 'btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Published Records')) . '</span>'; ?><script>$('#published').tooltip();</script>
                            <?php echo '<span class="badge btn-warning">' . $this->Html->link($unpublished, '#', array('id' => 'unpublished', 'class' => 'btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Unpublished Records')) . '</span>'; ?><script>$('#unpublished').tooltip();</script>
                            <?php echo '<span class="badge btn-danger">' . $this->Html->link($deleted, '#', array('id' => 'deleted', 'class' => 'btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Deleted Records')) . '</span>'; ?><script>$('#deleted').tooltip();</script>
                        <?php }
                        if($this->request->params['controller'] == 'stocks'){
                    if(isset($postData['sType'])){
                            $type = $postData['sType'];
                        }else{
                            $type = $this->request->params['pass'][0];
                        }
                    $this->Js->get('#addrecord');
                    $this->Js->event('click', $this->Js->request(array('action' => 'lists',$type), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#gridcall');
                    if (isset($this->request->params['named']['published'])){
                        $this->Js->event('click', $this->Js->request(array('action' => 'index',$type, 'published' => $this->request->params['named']['published']), array('async' => true, 'update' => '#main')));
                    }else{
                        $this->Js->event('click', $this->Js->request(array('action' => 'index',$type), array('async' => true, 'update' => '#main')));
                    }
                    $this->Js->get('#count');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index',$type, NULL), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#published');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index',$type, 'published' => 1), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#unpublished');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index',$type, 'published' => 0), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#deleted');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index',$type, 'soft_delete' => 1), array('async' => true, 'update' => '#main')));
                }else{
                            $this->Js->get('#count');
                            $this->Js->event('click', $this->Js->request(array('action' => $this->action, NULL), array('async' => true, 'update' => '#main')));
                            $this->Js->get('#published');
                            $this->Js->event('click', $this->Js->request(array('action' => $this->action, 'published' => 1), array('async' => true, 'update' => '#main')));
                            $this->Js->get('#unpublished');
                            $this->Js->event('click', $this->Js->request(array('action' => $this->action, 'published' => 0), array('async' => true, 'update' => '#main')));
                            $this->Js->get('#deleted');
                            $this->Js->event('click', $this->Js->request(array('action' => $this->action, 'soft_delete' => 1), array('async' => true, 'update' => '#main')));
                }
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
        <?php } else {?>
            <div class="row">
                <div class="col-md-8">
                    <h4><?php echo $this->element('breadcrumbs'); ?><?php echo h($postData["pluralHumanName"]); ?></h4>
                    <h4>
                        <?php if ($this->action != 'advanced_search' && $this->action != 'search') { ?>
                            <?php echo '<span class="badge btn-info">' . $this->Html->link($count, '#', array('id' => 'count', 'class' => 'btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')) . '</span>'; ?><script>$('#count').tooltip();</script>
                            <?php echo '<span class="badge btn-success">' . $this->Html->link($published, '#', array('id' => 'published', 'class' => 'btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Published Records')) . '</span>'; ?><script>$('#published').tooltip();</script>
                            <?php echo '<span class="badge btn-warning">' . $this->Html->link($unpublished, '#', array('id' => 'unpublished', 'class' => 'btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Unpublished Records')) . '</span>'; ?><script>$('#unpublished').tooltip();</script>
                            <?php echo '<span class="badge btn-danger">' . $this->Html->link($deleted, '#', array('id' => 'deleted', 'class' => 'btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Deleted Records')) . '</span>'; ?><script>$('#deleted').tooltip();</script>
                        <?php } ?>
                        <span class=""></span>
                        <?php if (!(($this->request->params['controller'] == 'file_uploads') || ($this->request->params['controller'] == 'reports') || ($this->request->params['controller'] == 'list_of_measuring_devices_for_calibrations') || (($this->request->params['controller'] == 'stocks') && $this->request->params['pass'][0] == 1))) { ?>
                            <?php echo $this->Html->link(__('Add'), array('action' => 'lists'), array('id' => 'addrecord', 'class' => 'label btn-primary', 'data-original-title' => 'Add New Record')); ?><script>$('#addrecord').tooltip();</script><?php } ?>
                        <?php
                            if (($this->request->params['controller'] == 'employees') || ($this->request->params['controller'] == 'branches') || ($this->request->params['controller'] == 'customers') || ($this->request->params['controller'] == 'products') || ($this->request->params['controller'] == 'devices') || ($this->request->params['controller'] == 'trainers') || ($this->request->params['controller'] == 'fireExtinguishers') || ($this->request->params['controller'] == 'ListOfComputers') || ($this->request->params['controller'] == 'ListOfSoftwares') || ($this->request->params['controller'] == 'supplier_registrations') || ($this->request->params['controller'] == 'housekeeping_checklists') || ($this->request->params['controller'] == 'housekeeping_responsibilities') || ($this->request->params['controller'] == 'customer_feedback_questions') || ($this->request->params['controller'] == 'list_of_computers') || ($this->request->params['controller'] == 'courses') || ($this->request->params['controller'] == 'list_of_acceptable_suppliers') || ($this->request->params['controller'] == 'summery_of_supplier_evaluations') ||  ($this->request->params['controller'] == 'materials') || ($this->request->params['controller'] == 'internal_audit_questions') || ($this->request->params['controller'] == 'fire_safety_equipment_lists') || ($this->request->params['controller'] == 'corrective_preventive_actions') || ($this->request->params['controller'] == 'designations') || ($this->request->params['controller'] == 'competency_mappings') || ($this->request->params['controller'] == 'trainings')  || ($this->request->params['controller'] == 'list_of_trained_internal_auditors') ||($this->request->params['controller'] == 'customer_complaints') ||($this->request->params['controller'] ==  'customer_feedbacks')
                          || ($this->request->params['controller'] ==  'customer_meetings')
                          || ($this->request->params['controller'] ==  'device_maintenances')
                          || ($this->request->params['controller'] ==  'fire_extinguishers')
                          || ($this->request->params['controller'] ==  'fire_safety_equipment_lists')
                          || ($this->request->params['controller'] ==  'list_of_softwares')
                          || ($this->request->params['controller'] ==  'proposals')
                          || ($this->request->params['controller'] ==  'appraisal_questions')
                            ) {
                                echo $this->Html->link(__('Import/Export'), '#import', array('id' => 'imp', 'class' => 'label btn-info', 'data-toggle' => 'modal', 'data-original-title' => 'Import Records', 'onClick' => 'show_hide();'));
                            }
                        ?>
                        <script>$('#imp').tooltip();</script>

                        <?php if (!(($this->request->params['controller'] == 'file_uploads'))){ ?>
                            <?php echo $this->Html->link(__('Delete All'), '#deleteAll', array('class' => 'label btn-danger', 'data-toggle' => 'modal', 'onClick' => 'getVals()')); ?>
                        <?php }?>
                        <span class=""></span>
                        <?php echo $this->Html->link('', array('action' => 'index'), array('id' => 'gridcall', 'class' => 'glyphicon glyphicon-list h4-title', 'data-original-title' => 'Switch to grid mode')); ?>
                        <script>$('#gridcall').tooltip();</script>
                    </h4>
                </div>
                <?php if (!(($this->request->params['controller'] == 'stocks') || ($this->request->params['controller'] == 'file_uploads'))){?>
                <?php echo $this->Html->link('Search', '#advanced_search', array('id' => 'ad_src', 'class' => 'btn btn-info pull-right', 'data-toggle' => 'modal', 'data-original-title' => 'Advanced Search', 'style' => 'margin-top:25px;margin-right:10px;padding-left:20px;padding-right:20px;')); ?>
                <script>$('#ad_src').tooltip();</script>
                <?php }?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </div>
            <?php

                if($this->request->params['controller'] == 'stocks'){
                    if(isset($postData['sType'])){
                            $type = $postData['sType'];
                        }else{
                            $type = $this->request->params['pass'][0];
                        }
                    $this->Js->get('#addrecord');
                    $this->Js->event('click', $this->Js->request(array('action' => 'lists',$type), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#gridcall');
                    if (isset($this->request->params['named']['published'])){
                        $this->Js->event('click', $this->Js->request(array('action' => 'index',$type, 'published' => $this->request->params['named']['published']), array('async' => true, 'update' => '#main')));
                    }else{
                        $this->Js->event('click', $this->Js->request(array('action' => 'index',$type), array('async' => true, 'update' => '#main')));
                    }
                    $this->Js->get('#count');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index',$type, NULL), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#published');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index',$type, 'published' => 1), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#unpublished');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index',$type, 'published' => 0), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#deleted');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index',$type, 'soft_delete' => 1), array('async' => true, 'update' => '#main')));
                }else{
                    $this->Js->get('#addrecord');
                    $this->Js->event('click', $this->Js->request(array('action' => 'lists'), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#gridcall');
                    if (isset($this->request->params['named']['published']))
                        $this->Js->event('click', $this->Js->request(array('action' => 'index', 'published' => $this->request->params['named']['published']), array('async' => true, 'update' => '#main')));
                    else
                      $this->Js->event('click', $this->Js->request(array('action' => 'index'), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#count');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index', NULL), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#published');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index', 'published' => 1), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#unpublished');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index', 'published' => 0), array('async' => true, 'update' => '#main')));
                    $this->Js->get('#deleted');
                    $this->Js->event('click', $this->Js->request(array('action' => 'index', 'soft_delete' => 1), array('async' => true, 'update' => '#main')));
                }
                    echo $this->Js->writeBuffer();

        }
    }
?>