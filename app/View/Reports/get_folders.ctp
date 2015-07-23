<div class="fDivs">
    <?php
        foreach ($folders[0] as $folder):
            echo $this->Html->link('<div class="btn-group btn-default" style="width:100%">
                                       <div class="' . str_replace(' ', '', $mId) . ' btn btn-xs glyphicon glyphicon-folder-close"  id="' . str_replace(' ', '', $folder[1]) . '-folder" ></div>
                                       <div class="btn btn-xs">' . Inflector::humanize(substr($folder[0], 0, 20)) . "...</div>
                                       </div>", '#', array('id' => str_replace(' ', '', $folder[1]), 'class' => 'a2', 'data' => $path . '/' . $folder[1] . '/', 'escape' => false));
        endforeach;

        foreach ($folders[1] as $file):
            if ($file != '.DS_Store' && $file != '.htaccess') {
                echo $this->Html->link('<div class="btn-group btn-default" style="width:100%">
                            <div class="btn btn-xs glyphicon glyphicon-file"></div>
                            <div class="btn btn-xs">' . substr($file, 0, 20) . "...</div>
                            </div>", '#', array('class' => 'f2', 'data' => $path . '/' . str_replace(' ', '<>', $file), 'escape' => false));
            }
        endforeach;
    ?>
</div>

<script>
    $('.a2').click(function() {

        $('#<?php echo str_replace(' ', '', $mId) ?>-div').load('get_folders/' + $(this).attr('data'))
        var newbtns = this.id + '-folder';
        $('.<?php echo str_replace(' ', '', $mId) ?>').removeClass('<?php echo str_replace(' ', '', $mId) ?> glyphicon-folder-open').addClass('<?php echo str_replace(' ', '', $mId) ?> glyphicon-folder-close');
        $('#' + newbtns).removeClass('glyphicon-folder-close').addClass('glyphicon-folder-open')
    });
</script>

<script>
    $('.f2').click(function() {
        $('#<?php echo str_replace(' ', '', $mId) ?>-div').load('get_file' + $(this).attr('data'))
    });
</script>

<div id="<?php echo str_replace(' ', '', $mId) ?>-div"></div>
