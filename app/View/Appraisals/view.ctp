<div id="appraisals_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel">
        <div class="appraisals form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Appraisal'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>

            <hr>
            <div class="row">
                <h5 class="text-center"><strong><?php echo __('Employee information'); ?></strong></h5>&nbsp;
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label><?php echo __('Employee Name'); ?></label><br />
                    <?php echo $this->Html->link($appraisal['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $appraisal['Employee']['id'])); ?>
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Date of Joining'); ?></label><br />
                    <?php echo h($appraisal['Employee']['joining_date']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label><?php echo __('Designation'); ?></label><br />
                    <?php echo h($PublishedDesignationList[$appraisal['Employee']['designation_id']]); ?>
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Date of Appraisal'); ?></label><br />
                    <?php echo h($appraisal['Appraisal']['appraisal_date']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label><?php echo __('Department'); ?></label><br />
                    <?php echo isset($PublishedDepartmentList[$appraisal['Employee']['departmentid']]) ? h($PublishedDepartmentList[$appraisal['Employee']['departmentid']]):''; ?>
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Appraiser'); ?></label><br />
                    <?php echo h($appraisal['AppraiserBy']['name']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label><?php echo __('Employee Number'); ?></label><br />
                    <?php echo h($appraisal['Employee']['employee_number']); ?>
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Self Appraisal Status'); ?></label><br />
                    <?php echo $appraisal['Appraisal']['self_appraisal_status'] ? __('Done') : __('Pending'); ?>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-center"><strong><?php echo __('Reason for Appraisal'); ?></strong></h5>&nbsp;
                    <br/>
                    <?php echo h($appraisal['Appraisal']['reason']); ?>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-center"><strong><?php echo __('Employee Appraisal Questions'); ?></strong></h5>&nbsp;
                    <br />
                    <?php foreach ($appraisal['EmployeeAppraisalQuestion'] as $quest): ?>
                        <strong><?php echo 'Question: ' . h($questions[$quest['appraisal_question_id']]); ?></strong>
                        <br/>
                        <?php echo '<strong>Answer: </strong>' . h($quest['answer']); ?>
                        <br/>&nbsp;
                        <br/>
                    <?php endforeach; ?>
                </div>
            </div>
            <hr>
            <?php
                $currentDate = strtotime(date('Y-m-d'));
                $appraisalDate = strtotime($appraisal['Appraisal']['appraisal_date']);
                if ($currentDate > $appraisalDate) {
            ?>
                <div class="row">
                    <div class="col-md-12 "><h5 class="text-center"><strong><?php echo __('Final Result and Recommendation'); ?></strong></h5></div>&nbsp;
                    <br/>
                    <div class="col-md-6">
                        <label><?php echo __('Rating'); ?></label><br />
                        <?php
                        if (isset($appraisal['Appraisal']['rating']))
                            echo $appraisal['Appraisal']['rating'];
                        else
                            echo '<p class="text-warning">' . __('No data available.') . '</p>';
                        ?>
                    </div>
                    <div class="col-md-12">
                        <label><?php echo __('Comments by Employee'); ?></label>
                        <br />
                        <?php
                        if (isset($appraisal['Appraisal']['employee_comments']))
                            echo $appraisal['Appraisal']['employee_comments'];
                        else
                            echo '<p class="text-warning">' . __('No data available.') . '</p>';
                        ?>
                    </div>

                    <br />&nbsp;
                    <br />

                    <div class="col-md-12">
                        <label><?php echo __('Comments by Appraiser'); ?></label>
                        <br />
                        <?php
                            if (isset($appraisal['Appraisal']['appraiser_comments']))
                                echo $appraisal['Appraisal']['employee_comments'];
                            else
                                echo '<p class="text-warning">' . __('No data available.') . '</p>';
                        ?>
                        <br />&nbsp;
                        <br />
                    </div>
                    <div class="col-md-6">
                        <label><?php echo __('Promotion'); ?></label>
                        <br />
                        <?php echo $appraisal['Appraisal']['promotion'] ? __('Yes') : __('No'); ?>
                    </div>
                    <div class="col-md-6">
                        <label><?php echo __('Warning'); ?></label>
                        <br />
                        <?php echo $appraisal['Appraisal']['warning'] ? __('Yes') : __('No'); ?>
                    </div>
                    <div class="col-md-6">
                        <label><?php echo __('Status Remained Unchanged'); ?></label>
                        <br />
                        <?php echo $appraisal['Appraisal']['status_remained_unchanged'] ? __('Yes') : __('No'); ?>
                    </div>
                    <div class="col-md-6">
                        <label><?php echo __('Successful Completion of Probation'); ?></label>
                        <br />
                        <?php echo $appraisal['Appraisal']['successful_probation_completion'] ? __('Yes') : __('No'); ?>
                    </div>
                    <div class="col-md-6">
                        <label><?php echo __('Salary Increment'); ?></label>
                        <br />
                        <?php echo $appraisal['Appraisal']['salary_increment'] ? __('Yes') : __('No'); ?>
                    </div>
                    <div class="col-md-6">
                        <label><?php echo __('Termination'); ?></label>
                        <br />
                        <?php echo $appraisal['Appraisal']['termination'] ? __('Yes') : __('No'); ?>
                    </div>
                    <div class="col-md-6">
                        <label><?php echo __('Training Requirements'); ?></label>
                        <br />
                        <?php echo $appraisal['Appraisal']['training_requirements'] ? __('Yes') : __('No'); ?>
                    </div>
                    <br />&nbsp;
                    <br />
                </div>

                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <label><?php echo __('Specific Requirement'); ?></label>
                        <br />
                        <?php
                            if (isset($appraisal['Appraisal']['specific_requirement']))
                                echo $appraisal['Appraisal']['specific_requirement'];
                            else
                                echo '<p class="text-warning">' . __('No data available.') . '</p>';
                        ?>
                    </div>

                    <div class="col-md-12">&nbsp;</div>

                    <div class="col-md-12">
                        <label><?php echo __('Increment'); ?></label>
                        <br />
                        <?php
                            if (isset($appraisal['Appraisal']['increament']))
                                echo $appraisal['Appraisal']['increament'];
                            else
                                echo '<p class="text-warning">' . __('No data available.') . '</p>';
                        ?>
                    </div>
                </div>&nbsp;
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label><?php echo __('Prepared By'); ?></label>
                            <br />
                            <?php echo h($appraisal['PreparedBy']['name']); ?>
                        </div>
                        <div class="col-md-6">
                            <label><?php echo __('Approved By'); ?></label>
                            <br />
                            <?php echo h($appraisal['ApprovedBy']['name']); ?>
                        </div>
                    </div>
                </div>

                <hr>
            <?php } ?>
            <?php if (count($kras)) echo $this->element('kra'); ?>
            <?php echo $this->element('upload-edit', array('usersId' => $appraisal['Appraisal']['created_by'], 'recordId' => $appraisal['Appraisal']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#appraisals_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $appraisal['Appraisal']['id'], 'ajax'), array('async' => true, 'update' => '#appraisals_ajax'))); ?>
<?php echo $this->Js->writeBuffer(); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>
