<div class="col-md-6">
    <?php echo $this->Form->input('Training.course_type_id', array('style' => 'width:100%', 'label' => __('Course Type'), 'default' => $course['Course']['course_type_id'])); ?>
</div>
<div class="col-md-12">
    <?php echo $this->Form->input('Training.title', array('style' => 'width:100%', 'label' => __('Training Title'), 'value' => $course['Course']['title'])); ?>
</div>
<div class="col-md-12">
    <?php echo $this->Form->input('Training.description', array('value' => $course['Course']['description'], 'label' => __('Training Details'))); ?>
</div>

<script>
    $("#TrainingCourseTypeId").chosen();
</script>