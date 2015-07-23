
<?php echo $this->Html->script(array('openwysiwyg/scripts/wysiwyg', 'openwysiwyg/scripts/wysiwyg-settings', 'jquery.min')); ?>
<script>
    $(document).ready(function() {
	WYSIWYG.attach('template-header', small);
    });
</script>

<div id="collapse-One" class="panel-collapse collapse in">
    <div class="panel-body">

        <textarea name="data['CustomTemplate']['header']" id="template-header"  style="float:left; clear:both; margin: 20px 0">
			<table cellpadding="2" cellspacing="2" border="1" width="100%" style="font-size:10px">
			    <tr>
			    <td colspan="4"><h2><?php echo $companyDetails['Company']['name'] ?> (ISO CERTIFICATION DOCUMENTS) :</h2>Powered by : FlinkISO �</td>
			    </tr>
			    <tr>
			    <td><?php echo __('Document Title'); ?></td><td>&nbsp;<?php echo h($details['MasterListOfFormat']['title']); ?></td>
			    <td><?php echo __('Document Number'); ?></td><td>&nbsp;<?php echo h($details['MasterListOfFormat']['document_number']); ?></td>
			    </tr>
			    <tr>
			    <td><?php echo __('Revision Number'); ?></td><td>&nbsp;<?php echo h($details['MasterListOfFormat']['revision_number']); ?></td>
			    <td><?php echo __('Revision Date'); ?></td><td>&nbsp;<?php echo h($details['MasterListOfFormat']['revision_date']); ?></td>
			    </tr>
			</table>
	</textarea>
    </div>
</div>

