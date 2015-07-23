<div id="dataTypes_ajax">
     <?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
    <?php echo $this->fetch('script'); ?>
    <?php echo $this->Session->flash(); ?>
    <script>
        $.validator.setDefaults({
            ignore: null,
            errorPlacement: function(error, element) {
                if ($(element).attr('name') == 'data[DataType][user_id]')
                    $(element).next().after(error);
                else {
                    $(element).after(error);
                }
            },
            submitHandler: function(form) {
                $('#DataTypeAddAjaxForm').ajaxSubmit({
                    url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_ajax",
                    type: 'POST',
                    target: <?php if($redirect){echo "'#dataTypes_ajax'";} else {echo "'#main'";}?>,
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
                return this.optional(element) || (parseFloat(value) > 0);
            }, "Please select the value");

            $('#DataTypeAddAjaxForm').validate({
                rules: {
                    "data[DataType][user_id]": {
                        greaterThanZero: true,
                    },
                }
            });
            $('#DataTypeUserId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
        });
    </script>

    <div class="nav">
        <div class="dataTypes form col-md-8">
             <script type="text/javascript">
                $(document).ready(function() {
                    $('.table-responsive table th a, .pag_list li span a').on('click', function() {
                    var url = $(this).attr("href");
                    $('#dataTypes_ajax').parent().load(url);
                    return false;
                });
                });
            </script>
        <div class="table-responsive">
            <h4>
                <?php echo __('List Data Type'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>

            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                  <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                  <th><?php echo $this->Paginator->sort('user_id'); ?></th>
                  <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($dataTypes) {
                        $x = 0;
                        foreach ($dataTypes as $dataType):
                ?>
                <tr>
                    <td><?php echo h($dataType['DataType']['name']); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($userNames[$dataType['User']['id']], array('controller' => 'users', 'action' => 'view', $dataType['User']['id'])); ?>
                    </td>

                    <td width="60">
                        <?php if ($dataType['DataType']['publish'] == 1) { ?>
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
                <tr><td colspan=15>No results found</td></tr>
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

            <h4><?php echo __('Add Data Type'); ?></h4>
            <?php echo $this->Form->create('DataType', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('name'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('user_id', array('style' => 'width:90%')); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('details'); ?></div>
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
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator'));?>
            <?php echo $this->Form->end(); ?>

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
<?php echo $this->element('checkbox-script'); ?>
<?php echo $this->Js->writeBuffer();