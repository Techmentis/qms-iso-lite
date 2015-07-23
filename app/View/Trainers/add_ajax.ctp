<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[Trainer][trainer_type_id]')
                $(element).next().after(error);
            else {
                $(element).after(error);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true);?><?php echo $this->request->params['controller']?>/add_ajax",
                type: 'POST',
                target: '#main',
                beforeSend: function(){
                   $("#submit_id").prop("disabled",true);
                    $("#submit-indicator").show();
                },
                complete: function() {
                   $("#submit_id").removeAttr("disabled");
                   $("#submit-indicator").hide();
                },
                error: function (request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
            });
        }
    });

    $().ready(function () {
	$("#submit-indicator").hide();
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");
        $('#TrainerAddAjaxForm').validate({
            rules: {
                "data[Trainer][personal_email]": {
                    email: true
                },
                "data[Trainer][office_email]": {
                    email: true
                },
                "data[Trainer][trainer_type_id]": {
                    greaterThanZero: true,

                },
                "data[Trainer][personal_telephone]": {
                    number: true

                },
                "data[Trainer][office_telephone]": {
                    number: true

                },
                "data[Trainer][mobile]": {
                    number: true

                }
            }
        });
        $('#TrainerTrainerTypeId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="trainers_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="trainers form col-md-8">
            <script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#trainers_ajax').load(url);
            return false;
        });
    });
</script>
        <h4>
                <?php echo __('List Trainers'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
        <div class="table-responsive">
          <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th><?php echo $this->Paginator->sort('trainer_type', __('Trainer Type')); ?></th>
                    <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                    <th><?php echo $this->Paginator->sort('company', __('Company')); ?></th>
                    <th><?php echo $this->Paginator->sort('designation', __('Designation')); ?></th>
                    <th><?php echo $this->Paginator->sort('qualification', __('Qualification')); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php if ($trainers) {
                        $x = 0;
                        foreach ($trainers as $trainer):
                ?>
                <tr>
                    <td><?php echo $trainer['TrainerType']['title']; ?>&nbsp;</td>
                    <td><?php echo $trainer['Trainer']['name']; ?>&nbsp;</td>
                    <td><?php echo $trainer['Trainer']['company']; ?>&nbsp;</td>
                    <td><?php echo $trainer['Trainer']['designation']; ?>&nbsp;</td>
                    <td><?php echo $trainer['Trainer']['qualification']; ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($trainer['Trainer']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                </tr>
                <?php
                    $x++;
                    endforeach;
                    } else {
                ?>
                <tr><td colspan=22><?php echo __('No results found'); ?></td></tr>
                <?php } ?>
            </table>
            </div>
        <p>
            <?php
                echo $this->Paginator->options(array(
                    'update' => '#main',
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

            <h4><?php echo __('Add Trainer'); ?></h4>
            <?php echo $this->Form->create('Trainer', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
                <fieldset>
                    <div class="col-md-6"><?php echo $this->Form->input('trainer_type_id', array('label' => __('Trainer Type'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('name', array('label' => __('Name'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('company', array('label' => __('Company'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('designation', array('label' => __('Designation'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('qualification', array('label' => __('Qualification'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('personal_telephone', array('label' => __('Personal Telephone'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('office_telephone', array('label' => __('Office Telephone'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('mobile', array('label' => __('Mobile'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('personal_email', array('label' => __('Personal Email'), 'maxlength' => 50)); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('office_email', array('label' => __('Office Email'), 'maxlength' => 50)); ?></div>
                    <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                    <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                    <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
                      <?php echo $this->Form->input('redirect', array('type' => 'hidden', 'value' => $redirect)); ?>
                </fieldset>
            </div>
            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#trainers_ajax', 'async' => 'false','id'=>'submit_id')); ?>
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
    $.ajaxSetup({
        beforeSend: function () {
            $("#busy-indicator").show();
        },
        complete: function () {
            $("#busy-indicator").hide();
        }
    });
</script>