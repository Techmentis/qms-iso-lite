<div class="">
    <h4><?php echo __('Human Resource Department Dashboard'); ?></h4>
</div>
<div class="main nav panel">
    <div class="nav panel-body">
        <div class="row  panel-default">
            <div class="col-md-8">

                <div class="row">
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Employee Master'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Before you can create any employee  make sure that you have already added ');
                                        echo $this->Html->link(__('Designations'), array('controller' => 'designations', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Branches'), array('controller' => 'branches', 'action' => 'index'), array('class' => 'text-primary'));
                                    ?><br /></p>
                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'employees', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'employees', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(' ' . $countEmployees, array('controller' => 'employees', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Employees'))); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Courses'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Before adding any Courses make sure that you have already added ');
                                        echo $this->Html->link(__('Course Types'), array('controller' => 'course_types', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Trainers'), array('controller' => 'trainers', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Trainer Types'), array('controller' => 'trainer_types', 'action' => 'index'), array('class' => 'text-primary'));
                                    ?><br /></p>
                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'courses', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'courses', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(' ' . $countCourses, array('controller' => 'courses', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'top', 'data-toggle' => 'tooltip', 'title' => __('No. of Courses'))); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('TNI'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Before you can add, access Training Need Identification  make sure you have added ');
                                        echo $this->Html->link(__('Courses'), array('controller' => 'courses', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Trainings'), array('controller' => 'trainings', 'action' => 'index'), array('class' => 'text-primary')) . __(' & ');
                                        echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index'), array('class' => 'text-primary'));
                                    ?>
                                </p>
                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'training_need_identifications', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'training_need_identifications', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(' ' . $countTNI, array('controller' => 'training_need_identifications', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'top', 'data-toggle' => 'tooltip', 'title' => __(' No. of Training Need Identifications'))); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <br/>

                <div class="row">
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Training Conducted'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Make sure you have already added ');
                                        echo $this->Html->link(__('Courses'), array('controller' => 'courses', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Training Types'), array('controller' => 'training_types', 'action' => 'index'), array('class' => 'text-primary'));
                                    ?><br/><br /></p>
                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'trainings', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'trainings', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(' ' . $countTrainings, array('controller' => 'trainings', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'top', 'data-toggle' => 'tooltip', 'title' => __('No. of Trainings'))); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Training Evaluations'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Make sure you have already added ');
                                        echo $this->Html->link(__('Trainings'), array('controller' => 'trainings', 'action' => 'index'), array('class' => 'text-primary'));
                                    ?><br/><br/></p>
                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'training_evaluations', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'training_evaluations', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(' ' . $countTrainingEvaluation, array('controller' => 'training_evaluations', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Training Evaluations'))); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Competency Mapping'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Make sure you have already added ');
                                        echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index'), array('class' => 'text-primary'));
                                    ?><br/><br/></p>
                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'competency_mappings', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'competency_mappings', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(' ' . $countCompetencyMappings, array('controller' => 'competency_mappings', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Competency Mappings'))); ?><script>$('.btn').tooltip();</script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">

                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Add Employee Appraisals'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Make sure you have already added ');
                                        echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index'), array('class' => 'text-primary')) . __(' & ');
                                        echo $this->Html->link(__('Appraisal Questions'), array('controller' => 'appraisal_questions', 'action' => 'index'), array('class' => 'text-primary'));
                                    ?><br/><br/></p>
                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'appraisals', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'appraisals', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(' ' . $countAppraisals, array('controller' => 'appraisals', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Appraisals'))); ?><script>$('.btn').tooltip();</script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br/>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="list-group-item-heading"><?php echo __('Available Quality Documents (HR Department)'); ?><span class="glyphicon glyphicon-eye-open pull-right"></span></h3>
                                <p class="list-group-item-text"><?php echo __('You can add/view your company Quality Manuals / Procedures / Objectives / Records / Policies for HR department by clicking on the links below. <br /> These documents are available for all users.'); ?></p>
                            </div>
                            <div class="panel-body">
                                <?php echo $this->Element('files',array('filesData' => array('files'=>$files,'action'=>$this->action))); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <?php echo $this->element('helps'); ?>
            </div>

        </div>

    </div>

</div>