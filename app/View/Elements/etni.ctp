<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title"><?php echo __('Training Need Indetification') ?></div>
    </div>
    <div class="panel-body">
        <table class="table table-responsive">
            <tr>
                <th><?php echo __('Course Title') ?></th>
                <th><?php echo __('Schedule') ?></th>
                <th><?php echo __('Remarks') ?></th>
            </tr>
            <?php foreach ($trainings as $training): ?>
                <tr>
                    <td><?php echo $training['Course']['title'] ?> </td>
                    <td><?php echo $training['Schedule']['name'] ?> </td>
                    <td><?php echo $training['TrainingNeedIdentification']['remarks'] ?> </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title"><?php echo __('Trainings attended') ?></div>
    </div>
    <div class="panel-body">
        <table class="table table-responsive">
            <tr>
                <th><?php echo __('Course/Training Title') ?></th>
                <th><?php echo __('Training Dates') ?></th>
            </tr>
            <?php foreach ($employeeTrainings as $employeeTraining): ?>
                <tr>
                    <td><?php echo $employeeTraining['Training']['title'] ?> </td>
                    <td><?php echo $employeeTraining['Training']['start_date_time'] ?>  to <?php echo $employeeTraining['Training']['end_date_time'] ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
