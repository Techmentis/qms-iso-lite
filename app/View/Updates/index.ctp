<?php
$file = new File(WWW_ROOT . DS .'files'. DS . 'version.txt');
$current_version = $file->read();
$file->close();
?>
<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
     $().ready(function () {
          $('#after_backup').hide();
    $("[name='data[update][backup_done]']").click(function(){
            var status = $("[name='data[update][backup_done]']:checked").val();
            var prm = $("[name='data[update][write_prm]']").val();
            if (status == 1 && prm) {
                $('#after_backup').show();
            } else {
                if (!prm)
                    alert('Please change your entire FlinkISO folder permissions to read-write (recursive) ');
                $('#after_backup').hide();
            }
        });
    });
</script>
<?php echo $this->Session->flash(); ?>
<div class="col-md-12">
      
    <h2>FlinkISO Upgrade Center <small>Current Version : <?php echo $current_version; ?></small></h2>
    <div class="col-md-12">
        <strong>Note :</strong>
        <br />Do not upgrade your application if you have customized it. This will over-write all your customization.
        <br /> Do not navigate to any other pages while system is updating.
        <br /> Windows/IIS users, please change your entire FlinkISO folder permissions to read-write (recursive)
    </div>
</div>
<div class="panel panel-body panel-default">
    <hr />
    <h4>Step : 1 - Backup FlinkISO</h4>
    <div class="col-md-12 panel panel-default panel-body" id="backup-files-div">
        <?php echo $this->Html->link('<h3>Backup Application Files First <br><small class="btn-danger">This will backup all your FlinkISO files <br />along with files, reports, evidences etc</small></h3>', array('action' => 'backup'), array('class' => 'pull-left btn btn-danger btn-lg col-md-5', 'escape' => false));
        ?>
        <p class="pull-left col-md-7">It is required that you take the entire files back up of your current FlinkISO application before you install new updates. Click on "Backup Application Files First" to begin backup. This will populate the compressed zip file. Save this zip file on a secure location. You might need it incase your backup is not successful.</p>
        <div class="clearfix">&nbsp;</div>
        <hr />
        <?php echo $this->Html->link('Backup Application Database First', array('action' => 'db_backup'), array('class' => 'pull-left btn btn-danger btn-lg col-md-5')); ?>
        <p class="pull-left col-md-7">It is required that you take the entire db back up of your current FlinkISO application before you install new updates. Click on "Backup Application Database First" to begin backup. This will populate the compressed zip file. Save this zip file on a secure location. You might need it incase your backup is not successful.</p>


        <?php
        if (!file_exists(WWW_ROOT . 'files' . DS . 'Updates')) {
            $createDir = new Folder(WWW_ROOT . 'files' . DS . 'Updates', TRUE, 0755);
        } else {
            $write_prm = is_writable(WWW_ROOT . DS . 'files' . DS . 'Updates');
            if (!$write_prm) {
                echo '<div class="clearfix">&nbsp;</div><hr />';
                echo '<div class="col-md-12 panel panel-default panel-body alert-danger">Your FlinkISO application folder doesn\'t have enough permission. Please change your FlinkISO folder permission to read-write (recursive)</div>';
            }
        }
        ?>
        <div class="clearfix">&nbsp;</div><hr />
        <?php echo $this->Form->create('update', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
        <?php echo $this->Form->input('backup_done', array('type' => 'checkbox', 'label' => 'I am done with backup'));?>
        <?php echo $this->Form->hidden('write_prm', array('value' => $write_prm));?>
        <?php echo $this->Form->end(); ?>
    </div>
    <div id="after_backup" >
    <div class="clearfix" >&nbsp;</div>
        <h4>Step : 2 - Upgrade FlinkISO <small>Panel marked red requires update</small></h4>
        <div class="panel panel-body panel-default">
        <?php
        if($available_updates){
            echo '<div class="panel-group" id="accordion">';
            $i = 1;
            foreach($available_updates as $key=>$updates):
                $up = false;
                $file = new File(WWW_ROOT.'files'.DS.'update.txt');
                $last_update = $file->read();
                    foreach ($updates as $a => $b) {
                        if ($a == 'update_id') {
                            if ($b == $last_update + 1) {
                                $class = 'panel-danger';
                                $panelClass = 'in';
                            } elseif ($b > $last_update + 1) {
                                $class = 'panel-warning';
                                $panelClass = 'out';
                            } else {
                                $class = 'panel-default';
                                $panelClass = 'out';
                            }
                        }

                        if ($a == 'description') {
                            $title = '<a href="#updator' . $i . '" data-toggle="collapse" data-parent="#accordion" >' . $b . '</a>';
                        }
                    }
                    echo '<div class="panel '.$class.'">';// panel start
                    echo '<div class="panel-heading">';// panel heading starts
                    echo '<h5 class="panel-title" style="font-weight:400; font-size:100%">';// panel title starts
                    echo $title;
                    if($class == 'panel-default') echo '<span class="glyphicon glyphicon-ok pull-right"></span>';
                    else {
                        echo '<span class="glyphicon glyphicon-download pull-right" id="download'.$i.'"></span><span class="glyphicon glyphicon-refresh pull-right" style="cursor: pointer;" id="refresh'.$i.'"></span>';
                    }
                    echo '</h5>';// panel title ends
                    echo "</div>";// panel heading ends
                    echo '<div id="updator'.$i.'" class="panel-collapse collapse '.$panelClass.'">'; // panel main starts
                    echo '<div class="panel-body">';// panel body starts
                    echo "<dl class='pull-left'>";

                    foreach($updates as $a => $b) {
                        if ($a != 'files' && $a != 'database' && $a != 'folder_path')
                            echo "<dt>" . Inflector::humanize($a), ' </dt><dd> ' . $b . "&nbsp;</dd>";
                        if ($a == 'update_id') {
                            if ($b == $last_update + 1) {
                                $up = true;
                                $req = false;
                                $newUpgrade = $b;
                            } elseif ($b > $last_update + 1) {
                                $up = false;
                                $req = true;
                            } else {
                                $up = false;
                                $req = false;
                            }
                        }
                    }
                    echo "</dl>";
        ?>
        <?php if($up){ ?>

            <script>
            $( document ).ready(function() {
                $("#spin<?php echo $i; ?>").hide();
                $("#refresh<?php echo $i; ?>").hide();
                $("#lk<?php echo $i;?>").click(function(){
                    $("#lk<?php echo $i;?>").removeClass('pull-left btn btn-info btn-lg');
                    $("#lk<?php echo $i;?>").addClass('pull-left btn btn-default btn-lg disabled');
                    $("#download<?php echo $i; ?>").hide();
                    $("#refresh<?php echo $i; ?>").show();
                    $("#spin<?php echo $i; ?>").show();
                    $(updator<?php echo $i; ?>).load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/upgrade/<?php echo $newUpgrade; ?>',
                            function(){
                                success:$("#spin<?php echo $i; ?>").hide();
                    });
                });

            });
            $( document ).ready(function() {
              $("#refresh<?php echo $i;?>").click(function(){$(updator<?php echo $i; ?>).load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/upgrade/<?php echo $newUpgrade; ?>')});
            });
            </script>
                <a href="#updator<?php echo $i; ?>" id="lk<?php echo $i; ?>" class="pull-left btn btn-info btn-lg" >Update</a>
                <?php echo $this->Html->Image('spinner2-black.gif',array('style'=>'width:15px;height;15px; margin-right:5px','class'=>'pull-left','id'=>'spin'.$i)); ?>

        <?php
            } else { ?>
                <script>
                    $("#spin<?php echo $i; ?>").hide();
                        $("#refresh<?php echo $i; ?>").hide();
                </script>
                <?php if($req)echo '<a href="#" class="pull-left btn btn-default btn-sm disabled" >First upgrade to previous update above.</a>';
                else echo '<a href="#" class="pull-left btn btn-default btn-sm disabled" >Updated!</a>';
            }
                $i++;
                echo '</div>';// panel body ends
                echo '</div>';// panel main ends
                echo "</div>";
                endforeach;
                echo "</div>";
                echo "</div>";
        }else{
            echo "Failed to retrive information";
        }
        ?>
        </div>
    </div>
</div>