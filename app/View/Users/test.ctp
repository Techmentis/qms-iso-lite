<div class="main user_access">
    <div class="panel">
        <div class="panel-heading">
            <h2><?php echo __('Set User Access'); ?></h2>
        </div>

        <div class="panel-body">
            <div class="panel-group" id="accordion">
                <?php echo $this->Form->create('User', array('role' => 'form', 'class' => 'form')); ?>
                <?php foreach ($forms as $value => $data): ?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h6>
                                    <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo str_replace(' ', '', ucfirst($value)); ?>" style="float:none">
                                        <?php echo $value ?>
                                    </a>

                                    <?php
                                        echo "<span style='float:right;margin-top:-20px;margin-right:10px'>" . $this->Form->input('select_all_' . str_replace(' ', '', ucfirst($value)), array('type' => 'checkbox', 'class' => $fkey . '_view', 'style' => 'float:left', 'label' => "Select All " . $value)) . "</span>";
                                    ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div id="<?php echo str_replace(' ', '', ucfirst($value)); ?>" class="panel panel-collapse collapse">
                        <div class="panel-body">

<script>
    $('#UserSelectAll<?php echo str_replace(' ', '', ucfirst($value)); ?>').on('click', function() {

        $("#<?php echo str_replace(' ', '', ucfirst($value)); ?>").find(':checkbox').prop('checked', this.checked);
        if (this.checked) {
            $("#<?php echo str_replace(' ', '', ucfirst($value)); ?>").find(':hidden').attr('value', 1);
        } else {
            $("#<?php echo str_replace(' ', '', ucfirst($value)); ?>").find(':hidden').attr('value', 0);
        }
    });
</script>
                            <?php foreach ($forms[$value] as $fkey => $fvalue):
                                    if ($fvalue) {
                            ?>

                                <div class="row">
                                    <div class="col-md-22"><?php echo "<strong>" . Inflector::Humanize($fkey) . "</strong>"; ?></div>
                                    <?php
                                        foreach ($fvalue['actions'] as $act):

                                            if ($act == 'index') {
                                                echo "<div class='col-md-2'>";
                                                echo $this->Form->input('ACL.user_access.' . $fkey . '.view', array('type' => 'checkbox', 'class' => $fkey . '_view'));
                                                if ($fkey == 'meetings') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.index', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.box', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.search', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.advanced_search', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                } elseif ($fkey == 'delivery_challans') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.index', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.box', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.search', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.advanced_search', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.inbound', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.outbound', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                } elseif ($fkey == 'internal_audit_plans') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.index', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.box', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.search', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.advanced_search', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.view_plan', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                } else {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.index', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.box', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.search', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.advanced_search', array('type' => 'checkbox', 'class' => $fkey . '_view', 'value' => 0));
                                                }
                                                echo "</div>";
                                            } elseif ($act == 'add') {
                                                echo "<div class='col-md-2'>";
                                                echo $this->Form->input('ACL.user_access.' . $fkey . '.add', array('type' => 'checkbox', 'class' => $fkey . '_add'));
                                                if ($fkey == 'internal_audits') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.audit_details_add_ajax', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.send_email', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'meetings') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_ajax', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_meeting_topics', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_after_meeting_topics', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.after_meeting', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'corrective_preventive_actions') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_ajax', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.capa_status', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_details', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'supplier_registrations') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_ajax', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_supplier_registration_title', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'delivery_challans') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_ajax', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_purchase_order', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_challan_details', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_challan_number', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'purchase_orders') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_ajax', array('type' => 'checkbox', 'class' => $fkey . '_add', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_purchase_order_details', array('type' => 'checkbox', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_purchase_order_number', array('type' => 'checkbox', 'value' => 0));
                                                } elseif ($fkey == 'internal_audit_plans') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_ajax', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_branches', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_departments', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_dept_clauses', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'supplier_evaluation_reevaluations') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_ajax', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_supplier_list', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'employees') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_ajax', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_employee_email', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'list_of_computers') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_ajax', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_new_software', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } else {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_ajax', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                }

                                                echo "</div>";
                                            } elseif ($act == 'edit') {
                                                echo "<div class='col-md-2'>";
                                                echo $this->Form->input('ACL.user_access.' . $fkey . '.edit', array('type' => 'checkbox'));
                                                if ($fkey == 'internal_audits') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.edit_popup', array('type' => 'checkbox', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.send_email', array('type' => 'checkbox', 'value' => 0));
                                                }
                                                if ($fkey == 'internal_audits') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.edit_popup', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.audit_details_add_ajax', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.send_email', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'meetings') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_after_meeting_topics', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.after_meeting', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'corrective_preventive_actions') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.capa_status', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_details', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'supplier_registrations') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_supplier_registration_title', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'delivery_challans') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_purchase_order', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_challan_details', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_challan_number', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'purchase_orders') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_ajax', array('type' => 'checkbox', 'class' => $fkey . '_add', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_purchase_order_details', array('type' => 'checkbox', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_purchase_order_number', array('type' => 'checkbox', 'value' => 0));
                                                } elseif ($fkey == 'internal_audit_plans') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_branches', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_departments', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_dept_clauses', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'supplier_evaluation_reevaluations') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_supplier_list', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'employees') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.get_employee_email', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                } elseif ($fkey == 'list_of_computers') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.add_new_software', array('type' => 'checkbox', 'class' => $fkey . '_add', 'value' => 0));
                                                }

                                                echo "</div>";
                                            } elseif ($act == 'delete') {
                                                echo "<div class='col-md-2'>";
                                                echo $this->Form->input('ACL.user_access.' . $fkey . '.delete', array('type' => 'checkbox'));
                                                echo $this->Form->hidden('ACL.user_access.' . $fkey . '.purge', array('type' => 'checkbox', 'value' => 0));
                                                echo "</div>";
                                            } elseif ($act == 'report') {
                                                echo "<div class='col-md-2'>";
                                                echo $this->Form->input('ACL.user_access.' . $fkey . '.report', array('type' => 'checkbox'));
                                                if ($fkey == 'internal_audits') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.audit_report', array('type' => 'checkbox', 'value' => 0));
                                                } elseif ($fkey == 'internal_audit_plans') {
                                                    echo $this->Form->hidden('ACL.user_access.' . $fkey . '.plan_report', array('type' => 'checkbox', 'value' => 0));
                                                }
                                                echo "</div>";
                                            } elseif (
                                                    $act != 'index' && $act != 'box' && $act != 'lists' && $act != 'add' && $act != 'approve' &&
                                                    $act != 'add_ajax' && $act != 'view' && $act != 'edit' && $act != 'search' && $act != 'evaluate' &&
                                                    $act != 'advanced_search' && $act != 'audit_details_add_ajax' && $act != 'send_email' &&
                                                    $act != 'meeting_detail_index' && $act != 'before_meeting_view' && $act != 'meeting_detail_lists' &&
                                                    $act != 'add_meeting_topics' && $act != 'add_after_meeting_topics' && $act != 'after_meeting' &&
                                                    $act != 'capa_status' && $act != 'get_details' && $act != 'get_supplier_registration_title' &&
                                                    $act != 'edit_popup' && $act != 'report' && $act != 'audit_report' &&
                                                    $act != 'get_purchase_order' && $act != 'get_challan_details' && $act != 'get_challan_number' &&
                                                    $act != 'inbound' && $act != 'outbound' &&
                                                    $act != 'add_purchase_order_details' && $act != 'get_purchase_order_number' &&
                                                    $act != 'add_branches' && $act != 'add_departments' && $act != 'get_dept_clauses' &&
                                                    $act != 'plan_report' && $act != 'view_plan' && $act != 'get_supplier_list' && $act != 'get_employee_email' && $act != 'user_access') {
                                                echo "<div class='col-md-2'>";
                                                echo $this->Form->input($act, array('type' => 'checkbox'));
                                                echo "</div>";
                                            }
                                        endforeach;
                                    ?>
                                </div>
                                <?php } endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success')); ?>
                <?php echo $this->Form->end(); ?>
                <?php echo $this->Js->writeBuffer(); ?>
            </div>
        </div>
    </div>
</div>