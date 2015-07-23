<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_ajax",
                type: 'POST',
                target:<?php if($redirect){echo "'#trainerTypes_ajax'";} else {echo "'#main'";}?>,
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
        $("#submit-indicator").prop("disabled","disabled");
        $('#TrainerTypeAddAjaxForm').validate();
    });
</script>

<div id="trainerTypes_ajax">
    <?php echo $this->Session->flash(); ?><div class="nav">
        <div class="trainerTypes form col-md-8">
            <h4><?php echo __('List of Trainer Type'); ?>&nbsp;
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?></h4>

<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#trainerTypes_ajax').load(url);
            return false;
        });
    });
</script>

            <div class="table-responsive" id="trainers_list">
                <table cellpadding="0" cellspacing="0" class="table table-bordered table-condensed table table-striped table-hover">
                    <tr>
                        <th><?php echo $this->Paginator->sort('title'); ?></th>
                        <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                    </tr>
                    <?php
                        if ($trainerTypes) {
                            $x = 0;
                            foreach ($trainerTypes as $trainerType):
                    ?>
                    <tr>
                        <td><?php echo h($trainerType['TrainerType']['title']); ?>&nbsp;</td>
                        <td width="160">
                            <?php if ($trainerType['TrainerType']['publish'] == 1) { ?>
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
                    <tr><td colspan=13><?php echo __('No results found'); ?></td></tr>
                    <?php } ?>
                </table>
            </div>
            <p>
                <?php
                    echo $this->Paginator->options(array(
                        'update' => '#trainers_list',
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

            <h4><?php echo __('Add New Trainer Type (Internal / External / Technical / Domain Experts etc)'); ?></h4>
            <?php echo $this->Form->create('TrainerType', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('title'); ?></div>
                <?php
                    echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id')));
                    echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id')));
                    echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id']));
                ?>
                 <?php echo $this->Form->input('redirect', array('type' => 'hidden', 'value' => $redirect)); ?>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php if($redirect){
                echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#trainerTypes_ajax', 'async' => 'false','id'=>'submit_id'));
		echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator'));
            }else{
                echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#trainerTypes_ajax', 'async' => 'false','id'=>'submit_id'));
		echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator'));
            }
            ?>
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
        }
    });
</script>