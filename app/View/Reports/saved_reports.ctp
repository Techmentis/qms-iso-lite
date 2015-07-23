<div class="row">
    <?php echo $this->Html->link('Search', '#advanced_search', array('id' => 'ad_src', 'class' => 'btn btn-info pull-right', 'data-toggle' => 'modal', 'data-original-title' => 'Advanced Search', 'style' => 'margin-top:25px;margin-right:10px;margin-bottom:10px;padding-left:20px;padding-right:20px;')); ?><script>$('#ad_src').tooltip();</script>
    <?php echo $this->Html->link('View All', array('controller' => 'reports', 'action' => 'index'), array('class' => 'btn btn-info pull-right', 'style' => 'margin-top:25px;margin-right:10px;margin-bottom:10px;padding-left:20px;padding-right:20px;')); ?>
    <div  class="col-md-12">
        <div id="file_uploads">
            <div class="panel panel-default">
                <div class="panel-heading"><div class="panel-title"><?php echo __('Saved Reports'); ?></div></div>
                <div class="panel-body free-scroll">

                    <div class="fDivs" style="width:307px; height: 450px;">
                        <?php
                        foreach ($folders[0] as $folder):
                            echo $this->Html->link('<span id="' . $folder . '-btn" class="btn-group btn-default" style="width:100%">
					       <span class="btn glyphicon glyphicon-folder-close" id="' . str_replace(' ', '', $folder) . '-folder" ></span>
					       <span class="btn">' . $folder . "</span></span>", '#', array('id' => str_replace(' ', '', $folder), 'class' => 'a1', 'data' => $folder, 'escape' => false));

                        endforeach;

                        foreach ($folders[1] as $file):
                            if ($file != '.DS_Store' && $file != '.htaccess')
                                echo $this->Html->link('<span class="btn-group btn-default" style="width:100%"><span class="btn glyphicon glyphicon-file"></span><span class="btn">' . str_replace(' ', '<>', $file) . "</span></span>", '#file_uploads', array('escape' => false));
                        endforeach;
                        ?>
                    </div>
                    <script>
                        $('.a1').click(function() {
                            $('#<?php echo str_replace(' ', '', $mId) ?>').load('get_folders/' + $(this).attr('data'))
                            var newbtns = this.id + '-folder';
                            $('.glyphicon-folder-open').removeClass('glyphicon-folder-open').addClass('glyphicon-folder-close');
                            $('#' + newbtns).removeClass('glyphicon-folder-close').addClass('glyphicon-folder-open')
                        });
                    </script>
                    <div id="<?php echo str_replace(' ', '', $mId) ?>"></div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "description" => "Description", "details" => "Details"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
</div>

<?php echo $this->Js->writeBuffer(); ?>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>