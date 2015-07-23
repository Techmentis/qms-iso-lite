<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $().ready(function() {
        $('#MeetingMeetingId').change(function() {
            $('#after_meeting').load("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/before_meeting_view/" + this.value);
        });
    });
</script>

<div id="meetings_ajax">
    <?php
        echo $this->Session->flash();
        $i = 0;
        $j = 1;
    ?>
    <div class="nav panel">
        <div class="meetings form col-md-8">
            <h4><?php echo __('Add Meeting Details'); ?></h4>
            <?php echo $this->Form->create('Meeting', array('role' => 'form', 'class' => 'form', 'default' => false, 'style' => "margin-bottom:0px;")); ?>
            <div class="col-md-12"><?php echo $this->Form->input('meeting_id', array('style' => 'width:100%', 'label' => __('Select Meeting'))); ?></div>
            <?php echo $this->Form->end(); ?>
            <?php if (!$meetings) { ?>
                <div class="alert alert-info">
                    <b><?php echo __('Why I am seeing this?') ?></b>
                    <p><?php echo __('You can only add meeting details to any meeting after the meeting date. Currently no such meetings are available or they are scheduled for future date.'); ?>
                    </p>
                </div>
            <?php } ?>
            <?php echo $this->Js->writeBuffer(); ?>
            <div class="col-md-12"><div id = "after_meeting">
                    <div class="alert alert-warning"><strong>Note : </strong><p><?php echo __('You can add meeting details for meeting already conducted. Select meeting from the drop-down to add details ') ?></p></div>
                </div>
            </div>
            <?php $i++; $j++; ?>
        </div>

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