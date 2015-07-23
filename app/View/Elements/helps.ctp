<?php if($this->Session->read('User')) { ?>
<div id="display_fetched_files">
<p class="text-center"><br />
    <?php echo $this->Html->link(__('<span class="pull-left">Fetch All Related Files</span><small class="pull-right badge label-info">New!</small>'),'#display_fetched_files',array('id'=>'fetch_files', 'style'=>'width:100%; font-wight:bold; font-size:16px; text-align:left' ,'class'=>'btn btn-primary','escape'=>false)); ?>
    <small>Get all your files related to this record here! </small>
</p>
</div>
<?php } ?>
<div class="panel-group" id="accordion">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <?php echo __("Upgrade!") ?><span class="glyphicon glyphicon-thumbs-up pull-right"></span>
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse  in">
            <div class="panel-body">
                You are installing FlinkISO Lite version with limited features. Upgraded version is already available. To get the upgraded version, you can purchase any of our support packs. To upgrade your copy contact us at :
                <h4 class="text-success"><?php echo __('sales@flinkiso.com'); ?></h4>                
                </div>
        </div>
    </div>
    <?php if($this->Session->read('User'))echo $this->element('customise'); ?>
    <?php $acc = 1 ?>
    <?php foreach ($helps as $help): ?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $acc; ?>">
                        <?php echo $help['Help']['title']; ?>
                    </a>
                </h4>
            </div>
            <div id="collapse<?php echo $acc; ?>" class="panel-collapse collapse">
                <div class="panel-body">
                    <?php echo $help['Help']['help_text']; ?>
                </div>
            </div>
        </div>
    <?php $acc++; ?>
    <?php endforeach; ?>
    <?php
        $controller = $this->request->params['controller'];
        $model = Inflector::Classify($controller);
    ?>
    <?php if ($this->request->params['controller'] != 'messages' && $this->request->params['controller'] != 'dashboards' && $this->request->params['controller'] != 'benchmarks' && $this->request->params['controller'] != 'file_uploads' && $this->request->params['controller'] !='installer') { ?>

        <?php if ($this->action != 'add' and $this->action != 'add_ajax' && $this->action != 'smtp_details') { ?>
            <?php
                if (isset($this->data[Inflector::Classify($this->name)]) && $this->data[Inflector::Classify($this->name)]['publish'] == 1 or $this->viewVars[Inflector::variable($model)][$model]['publish'] == 1)
                    echo '<div class="panel panel-success">';
                else
                    echo '<div class="panel panel-danger">';
            ?>
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">

                        <?php
                            if (isset($this->data[Inflector::Classify($this->name)]) && $this->data[Inflector::Classify($this->name)]['publish'] == 1 or $this->viewVars[Inflector::variable($model)][$model]['publish'] == 1)
                                echo 'Approval History (Approved)';
                            else
                                echo 'Approval History (Pending)';
                        ?>
                        <?php
                            if (isset($this->data[Inflector::Classify($this->name)]) && $this->data[Inflector::Classify($this->name)]['publish'] == 1 or $this->viewVars[Inflector::variable($model)][$model]['publish'] == 1)
                                echo '<span class="badge btn-success pull-right">' . $approvalHistory['count'] . '</span>';
                            else
                                echo '<span class="badge btn-danger pull-right">' . $approvalHistory['count'] . '</span>';
                        ?>
                    </a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse">
                <div class="panel-body">
                    <h5>Available in upgraded version</h5>
                    <p>You can set up your own approval process. Send records for multiple approvals. Add files for every approval step. Once the record is published, you can fetch all those files by clicking on "Fetch All Related File" button.</p>
                </div>
            </div>
        </div>
    <?php } if($controller!='installer' && $this->action != 'smtp_details') { ?>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                    <?php echo __('Document Details'); ?>
                </a>
                <span class="glyphicon glyphicon-file pull-right"></span>
            </h4>
        </div>
        <div id="collapseFive" class="panel-collapse collapse">
            <div class="panel-body">
                <dl>
                    <dt><?php echo __('Document Title'); ?></dt><dd><?php echo $documentDetails['MasterListOfFormat']['title'] ?></dd>
                    <dt><?php echo __('Issue'); ?></dt><dd><?php echo $documentDetails['MasterListOfFormat']['issue_number'] ?></dd>
                    <dt><?php echo __('Revision'); ?></dt><dd><?php echo $documentDetails['MasterListOfFormat']['revision_number'] ?></dd>
                    <dt><?php echo __('Revision Date'); ?></dt><dd><?php echo $documentDetails['MasterListOfFormat']['revision_date'] ?></dd>
                </dl>
            </div>
        </div>
    </div>
    <?php } } ?>
<?php if($controller =='installer' && $this->action == 'index') { ?>
     <div class="panel panel-info">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                    <?php echo __('Database Configuration'); ?>
                </a>
                <span class="glyphicon glyphicon-wrench pull-right"></span>
            </h4>
        </div>
        <div id="collapseFive" class="panel-collapse collapse">
            <div class="panel-body">
                <p>As any software would, FlinkISO&trade; also stores all its data into a database.</p>
                <p>You will have to enter your database host, username, password along with the name you would like to give to a new database.</p>
                <p>You can leave the prefix blank</p>
                <p>Please note: This installer only supports MySQL database at this point of time.</p>
                <p>Once you enter the correct credentials, installer will create and install new database.</p>
                <p></p>
            </div>
        </div>
    </div>
     <?php } ?>
<?php if($controller =='installer' && $this->action == 'smtp_details') { ?>
     <div class="panel panel-info">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                    <?php echo __('Why SMTP details are rquired?'); ?>
                </a>
                <span class="glyphicon glyphicon-file pull-right"></span>
            </h4>
        </div>
        <div id="collapseFive" class="panel-collapse collapse">
            <div class="panel-body">
                <p>SMTP stands for Simple Mail Transfer Protocol. It's a set of communication guidelines that allow software to transmit email over the Internet.</p>
                <p>FlinkISO&trade; requires your or your organisation email to send emails and other system required notification, reminders etc to your users who will use FlinkISO&trade; with you.</p>
                <p>Your email, specially email password will not be transmitted over the internet and it is safe to add those details.</p>
                <p></p>
            </div>
        </div>
    </div>
     <?php } ?>
    <?php if($this->Session->read('User')) { ?> 
    <div class="panel no-padding">
            <div class="panel-body no-padding text-center"><br />
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- help-ads -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:336px;height:280px"
                     data-ad-client="ca-pub-2922039071440353"
                     data-ad-slot="7281775427"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
    </div>
	<?php } ?>

<script>
    $(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({allow_single_deselect: true});
    });
</script>
