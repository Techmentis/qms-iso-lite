<div id="dataBackUps_ajax">
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
    <?php echo $this->fetch('script'); ?>

    <script>
        $.validator.setDefaults({
            ignore: null,
            errorPlacement: function(error, element) {
                if ($(element).attr('name') == 'data[DataBackUp][data_type_id]' ||
                        $(element).attr('name') == 'data[DataBackUp][branch_id]' ||
                        $(element).attr('name') == 'data[DataBackUp][schedule_id]') {
                    $(element).next().after(error);
                } else {
                    $(element).after(error);
                }
            },
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_ajax",
                    type: 'POST',
                    target:<?php if($redirect){echo "'#dataBackUps_ajax'";} else {echo "'#main'";}?>,
                    beforeSend: function(){
                       $("#submit_id").prop("disabled",true);
                        $("#submit-indicator").show();
                    },
                    complete: function() {
                       $("#submit_id").removeAttr("disabled");
                       $("#submit-indicator").hide();
                    },
                    error: function(request, status, error) {
                        //alert(request.responseText);
			alert('Action failed!');
                    }
                });
            }
        });

        $().ready(function() {
            $("#submit-indicator").hide();
            jQuery.validator.addMethod("greaterThanZero", function(value, element) {
                return this.optional(element) || (value != -1);
            }, "Please select the value");

            $('#DataBackUpAddAjaxForm').validate({
                rules: {
                    "data[DataBackUp][data_type_id]": {
                        greaterThanZero: true,
                    },
                    "data[DataBackUp][branch_id]": {
                        greaterThanZero: true,
                    },
                    "data[DataBackUp][schedule_id]": {
                        greaterThanZero: true,
                    }
                }
            });
            $('#DataBackUpDataTypeId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
            $('#DataBackUpBranchId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
            $('#DataBackUpScheduleId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });

        });
    </script>

    <div class="nav">
        <div class="dataBackUps form col-md-8">
            <script type="text/javascript">
                $(document).ready(function() {
                    $('.table-responsive table th a, .pag_list li span a').on('click', function() {
                    var url = $(this).attr("href");
                    $('#dataBackUps_ajax').parent().load(url);
                    return false;
                });
                });
            </script>

        <div class="table-responsive">
            <h4>
                <?php echo __('List Data Backups'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                    <th><?php echo $this->Paginator->sort('data_type_id', __('Data Type')); ?></th>
                    <th><?php echo $this->Paginator->sort('branch_id', __('Branch')); ?></th>
                    <th><?php echo $this->Paginator->sort('schedule_id', __('Backup Schedule')); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($dataBackUps) {
                        $x = 0;
                        foreach ($dataBackUps as $dataBackUp):
                ?>
                <tr>
                    <td width="50"><?php echo h($dataBackUp['DataBackUp']['name']); ?>&nbsp;</td>
                    <td><?php echo $this->Html->link($dataBackUp['DataType']['name'], array('controller' => 'data_types', 'action' => 'view', $dataBackUp['DataType']['id'])); ?></td>
                    <td><?php echo $this->Html->link($dataBackUp['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $dataBackUp['Branch']['id'])); ?></td>
                    <td><?php echo $this->Html->link($dataBackUp['Schedule']['name'], array('controller' => 'schedules', 'action' => 'view', $dataBackUp['Schedule']['id'])); ?></td>
                    <td width="60">
                        <?php if ($dataBackUp['DataBackUp']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;
                    </td>
                </tr>
                <?php
                    $x++;
                    endforeach;
                    } else {
                ?>
                <tr><td colspan=16><?php echo __('No results found'); ?></td></tr>
                <?php } ?>
            </table>
            </div>

        <p>
            <?php
                echo $this->Paginator->options(array(
                    'update' => '#dataTypes_ajax',
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
            <h4><?php echo __('Add Data Back Up'); ?></h4>
            <?php echo $this->Form->create('DataBackUp', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('name', array('style' => 'width:100%', 'label' => __('Name'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('data_type_id', array('style' => 'width:100%', 'label' => __('Data Type'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('branch_id', array('style' => 'width:100%', 'label' => __('Branch'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('schedule_id', array('style' => 'width:100%', 'label' => __('Backup Schedule'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('user_id', array('style' => 'width:100%', 'label' => __('User Responsible'))); ?></div>
                <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
                <?php echo $this->Form->input('redirect', array('type' => 'hidden', 'value' => $redirect)); ?>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php
            if($redirect){
                echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' =>'#dataTypes_ajax', 'async' => 'false','id'=>'submit_id'));
            }else{
                echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#dataTypes_ajax', 'async' => 'false','id'=>'submit_id'));
            }
            ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>

        </div>
        <script>
            $("[name*='date']").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
            });
        </script>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>
<?php echo $this->Js->writeBuffer();