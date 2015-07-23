<script>
    $('document').ready(function() {
        $("#month").change(function() {
            var date_value = $(this).val().replace("-", "/");
            window.location = '<?php echo Router::url('/', true); ?>reports/report_center/' + date_value;
        });
        $('#month').chosen();
    });


</script>
<?php
$curr_month = isset($this->request->params['pass'][0]) && ($this->request->params['pass'][1]) ? $this->request->params['pass'][1].'-'.$this->request->params['pass'][0] : '';

if ($curr_month) {
    $curr_month = $curr_month;
} else {
    $curr_month = date('Y-m');
}
?>
<div class="main">
    <div class="row">
        <div class="col-md-8">
            <h1><?php echo __("FlinkISO Report Center") ?></h1>
        </div>
        <div class="col-md-4"><h3 class="text-success"><?php echo __("Ready reports for "); ?><?php echo date('M-Y', strtotime($curr_month)) ?></h3></div>
        <div class="col-md-8">
            <div class="alert alert-info">
                <?php echo __('These are ready reports generated automatically based on the inputs by flinkISO users. These reports are auto-generated daily, weekly, quarterly & yearly.'); ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php
            $end_date = date('Y-m-1');
            $date = date("Y-m-d", strtotime("-11 month", strtotime($end_date)));
            while ($date < $end_date) {
                $options[date('Y', strtotime($end_date))][date('m-Y', strtotime($end_date))] = date('M-Y', strtotime($end_date));
                $end_date = date("Y-m-d", strtotime("-1 month", strtotime($end_date)));
            }
            echo $this->Form->input('month', array('id' => 'month', 'label' => __('Change Month'), 'options' => $options));
            ?>
        </div>
    </div>
    <h3><?php echo __('Daily Report'); ?></h3>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5><?php echo __('Daily Data Entry Reports'); ?></h5>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <tr>
                            <?php echo ('<th>' . __('File Name') . '</th><th>' . __('Size') . '</th><th>' . __('Created On') . '</th>'); ?>
                        </tr>
                        <?php
                        $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/DailyDataEntry');
                        $folders = $dir->read(true);
                        foreach ($folders[0] as $folder):
                            $exist = strstr($folder, $curr_month);
                            if($exist == $folder){
                                $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/DailyDataEntry/'.$folder);
                                $files = $dir->read(true);
                                foreach ($files[1] as $file):
                                    $file = new File(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/DailyDataEntry/' .$folder.'/'. $file);
                                    $fileDetails = $file->info();
                                    if ($fileDetails['extension'] == 'xls' && $fileDetails['extension'] != '') {
                                        echo "<tr><td>" . $this->Html->link($fileDetails['basename'], '../files/' . $this->Session->read('User.company_id') . '/Reports/DailyDataEntry/'. $folder. '/' . $fileDetails['basename'], array('class' => 'text-info')) . "</div>";
                                        echo "</td><td>";
                                        if ($fileDetails['filesize'] < 1000000) {
                                            echo round($fileDetails['filesize'] / 1024) . 'kb';
                                        } else {
                                            echo round($fileDetails['filesize'] / 1024) . 'kb';
                                        }
                                        echo "</td><td>";
                                        echo date('Y-M-d h:m', $file->lastChange());
                                        echo "</td></tr>";
                                }
                                endforeach;
                            }
                        endforeach;
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5><?php echo __('Daily Data Backup Report'); ?></h5>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <tr>
                            <?php echo ('<th>' . __('File Name') . '</th><th>' . __('Size') . '</th><th>' . __('Created On') . '</th>'); ?>
                        </tr>
                        <?php
                        $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/DatabackupLogbook');
                        $folders = $dir->read(true);
                        foreach ($folders[0] as $folder):
                            $exist = strstr($folder, $curr_month);
                            if($exist == $folder){
                                $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/DatabackupLogbook/'.$folder);
                                $files = $dir->read(true);
                                foreach ($files[1] as $file):
                                    $file = new File(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/DatabackupLogbook/' .$folder.'/'. $file);
                                    $fileDetails = $file->info();
                                    if ($fileDetails['extension'] == 'xls' && $fileDetails['extension'] != '') {
                                        echo "<tr><td>" . $this->Html->link($fileDetails['basename'], '../files/' . $this->Session->read('User.company_id') . '/Reports/DatabackupLogbook/'. $folder. '/' . $fileDetails['basename'], array('class' => 'text-info')) . "</div>";
                                        echo "</td><td>";
                                        if ($fileDetails['filesize'] < 1000000) {
                                            echo round($fileDetails['filesize'] / 1024) . 'kb';
                                        } else {
                                            echo round($fileDetails['filesize'] / 1024) . 'kb';
                                        }
                                        echo "</td><td>";
                                        echo date('Y-M-d h:m', $file->lastChange());
                                        echo "</td></tr>";
                                }
                                endforeach;
                            }
                        endforeach;
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <h3><?php echo __('Weekly Reports'); ?></h3>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5><?php echo __('Weekly Non-Conformity Report'); ?></h5>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <tr>
                            <?php echo ('<th>' . __('File Name') . '</th><th>' . __('Size') . '</th><th>' . __('Created On') . '</th>'); ?>
                        </tr>
                        <?php
                        $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/WeeklyNCReport');
                        $folders = $dir->read(true);
                        foreach ($folders[0] as $folder):
                            $exist = strstr($folder, $curr_month);
                            if($exist == $folder){
                                $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/WeeklyNCReport/'.$folder);
                                $files = $dir->read(true);
                                foreach ($files[1] as $file):
                                    $file = new File(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/WeeklyNCReport/' .$folder.'/'. $file);
                                    $fileDetails = $file->info();
                                    if ($fileDetails['extension'] == 'xls' && $fileDetails['extension'] != '') {
                                        echo "<tr><td>" . $this->Html->link($fileDetails['basename'], '../files/' . $this->Session->read('User.company_id') . '/Reports/WeeklyNCReport/'. $folder. '/' . $fileDetails['basename'], array('class' => 'text-info')) . "</div>";
                                        echo "</td><td>";
                                        if ($fileDetails['filesize'] < 1000000) {
                                            echo round($fileDetails['filesize'] / 1024) . 'kb';
                                        } else {
                                            echo round($fileDetails['filesize'] / 1024) . 'kb';
                                        }
                                        echo "</td><td>";
                                        echo date('Y-M-d h:m', $file->lastChange());
                                        echo "</td></tr>";
                                }
                                endforeach;
                            }
                        endforeach;
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <?php
        $i = 1;
        foreach ($weekly_model_list as $model_name) {
            ?>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <h5><?php echo Inflector::humanize(Inflector::underscore($model_name)) . " Report"; ?></h5>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            <tr>
                                <?php echo ('<th>' . __('File Name') . '</th><th>' . __('Size') . '</th><th>' . __('Created On') . '</th>'); ?>
                            </tr>
                            <?php
                            $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/Weekly/' . $model_name);
                            $folders = $dir->read(true);
                            foreach ($folders[0] as $folder):
                                $exist = strstr($folder, $curr_month);
                                if($exist == $folder){
                                    $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/Weekly/' . $model_name.'/'.$folder);
                                    $files = $dir->read(true);
                                    foreach ($files[1] as $file):
                                        $file = new File(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/Weekly/' . $model_name.'/'.$folder.'/'. $file);
                                        $fileDetails = $file->info();
                                        if ($fileDetails['extension'] == 'xls' && $fileDetails['extension'] != '') {
                                            echo "<tr><td>" . $this->Html->link($fileDetails['basename'], '../files/' . $this->Session->read('User.company_id') . '/Reports/Weekly/' . $model_name.'/' .$folder.'/' . $fileDetails['basename'], array('class' => 'text-info')) . "</div>";
                                            echo "</td><td>";
                                        if ($fileDetails['filesize'] < 1000000) {
                                            echo round($fileDetails['filesize'] / 1024) . 'kb';
                                        } else {
                                            echo round($fileDetails['filesize'] / 1024) . 'kb';
                                        }
                                        echo "</td><td>";
                                        echo date('Y-M-d h:m', $file->lastChange());
                                        echo "</td></tr>";
                                        }
                                    endforeach;
                                }
                            endforeach;
                            ?>
                        </table>
                    </div>
                </div>
            </div>

            <?php
            $i++;
            if ($i % 2 == 0) {
                ?>

            </div>
            <div class="row">
                <?php
            }
        }
        ?>
    </div>
</div>



<h3><?php echo __('Monthly Reports'); ?></h3>
<div class="row">
    <?php
    $i = 0;
    foreach ($model_list as $model_name) {
        ?>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <h5><?php echo Inflector::humanize(Inflector::underscore($model_name)) . " Report"; ?></h5>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <tr>
                            <?php echo ('<th>' . __('File Name') . '</th><th>' . __('Size') . '</th><th>' . __('Created On') . '</th>'); ?>
                        </tr>
                        <?php
                        $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/Monthly/' . $model_name);
                        $folders = $dir->read(true);
                            foreach ($folders[0] as $folder):
                                $exist = strstr($folder, $curr_month);
                                if($exist == $folder){
                                    $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/Monthly/' . $model_name.'/'.$folder);
                                    $files = $dir->read(true);
                                    foreach ($files[1] as $file):
                                        $file = new File(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/Reports/Monthly/' . $model_name.'/'.$folder.'/'. $file);
                                        $fileDetails = $file->info();
                                        if ($fileDetails['extension'] == 'xls' && $fileDetails['extension'] != '') {
                                            echo "<tr><td>" . $this->Html->link($fileDetails['basename'], '../files/' . $this->Session->read('User.company_id') . '/Reports/Monthly/' . $model_name.'/' .$folder.'/'. $fileDetails['basename'], array('class' => 'text-info')) . "</div>";
                                            echo "</td><td>";
                                        if ($fileDetails['filesize'] < 1000000) {
                                            echo round($fileDetails['filesize'] / 1024) . 'kb';
                                        } else {
                                            echo round($fileDetails['filesize'] / 1024) . 'kb';
                                        }
                                        echo "</td><td>";
                                        echo date('Y-M-d h:m', $file->lastChange());
                                        echo "</td></tr>";
                                        }
                                    endforeach;
                                }
                            endforeach;
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <?php
            $i++;
            if ($i % 2 == 0) {
        ?>

        </div>
        <div class="row">
    <?php
            }
    }
    ?>
</div>
